<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShipmentApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Branch $branch;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $this->branch = Branch::create([
            'name' => 'Test Branch',
            'code' => 'TEST',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'is_active' => true,
        ]);
        $this->user = User::factory()->create(['branch_id' => $this->branch->id]);
        $this->user->assignRole('operator');
        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    public function test_can_create_shipment(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/shipments', [
                'branch_id' => $this->branch->id,
                'sender_name' => 'John Sender',
                'sender_phone' => '9876543210',
                'sender_address' => '123 Test St',
                'sender_city' => 'Mumbai',
                'sender_state' => 'Maharashtra',
                'sender_pincode' => '400001',
                'receiver_name' => 'Jane Receiver',
                'receiver_phone' => '9876543211',
                'receiver_address' => '456 Recv St',
                'receiver_city' => 'Delhi',
                'receiver_state' => 'Delhi',
                'receiver_pincode' => '110001',
                'weight' => 1.5,
                'service_type' => 'standard',
                'payment_mode' => 'prepaid',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'awb_number', 'status', 'trackings']);

        $this->assertDatabaseHas('shipments', [
            'sender_name' => 'John Sender',
            'status' => 'booked',
        ]);
    }

    public function test_can_track_shipment_publicly(): void
    {
        $shipment = Shipment::create([
            'awb_number' => 'TEST2400010001',
            'branch_id' => $this->branch->id,
            'created_by' => $this->user->id,
            'sender_name' => 'Test Sender',
            'sender_phone' => '9876543210',
            'sender_address' => 'Test Address',
            'sender_city' => 'Mumbai',
            'sender_state' => 'Maharashtra',
            'sender_pincode' => '400001',
            'receiver_name' => 'Test Receiver',
            'receiver_phone' => '9876543211',
            'receiver_address' => 'Recv Address',
            'receiver_city' => 'Delhi',
            'receiver_state' => 'Delhi',
            'receiver_pincode' => '110001',
            'weight' => 1.0,
            'booking_date' => today(),
            'status' => 'booked',
        ]);

        $response = $this->getJson('/api/track/' . $shipment->awb_number);

        $response->assertStatus(200)
            ->assertJsonPath('awb_number', $shipment->awb_number)
            ->assertJsonPath('status', 'booked');
    }

    public function test_can_update_shipment_status(): void
    {
        $shipment = Shipment::create([
            'awb_number' => 'TEST2400010002',
            'branch_id' => $this->branch->id,
            'created_by' => $this->user->id,
            'sender_name' => 'Test Sender',
            'sender_phone' => '9876543210',
            'sender_address' => 'Test Address',
            'sender_city' => 'Mumbai',
            'sender_state' => 'Maharashtra',
            'sender_pincode' => '400001',
            'receiver_name' => 'Test Receiver',
            'receiver_phone' => '9876543211',
            'receiver_address' => 'Recv Address',
            'receiver_city' => 'Delhi',
            'receiver_state' => 'Delhi',
            'receiver_pincode' => '110001',
            'weight' => 1.0,
            'booking_date' => today(),
            'status' => 'booked',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson("/api/shipments/{$shipment->id}/track", [
                'status' => 'in_transit',
                'location' => 'Mumbai Hub',
                'remarks' => 'Package in transit',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('shipments', ['id' => $shipment->id, 'status' => 'in_transit']);
    }

    public function test_cannot_create_shipment_without_auth(): void
    {
        $response = $this->postJson('/api/shipments', [
            'branch_id' => $this->branch->id,
            'sender_name' => 'Test',
        ]);

        $response->assertStatus(401);
    }

    public function test_awb_is_auto_generated(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/shipments', [
                'branch_id' => $this->branch->id,
                'sender_name' => 'Sender',
                'sender_phone' => '9876543210',
                'sender_address' => 'Address',
                'sender_city' => 'Mumbai',
                'sender_state' => 'Maharashtra',
                'sender_pincode' => '400001',
                'receiver_name' => 'Receiver',
                'receiver_phone' => '9876543211',
                'receiver_address' => 'Recv Address',
                'receiver_city' => 'Delhi',
                'receiver_state' => 'Delhi',
                'receiver_pincode' => '110001',
                'weight' => 0.5,
            ]);

        $response->assertStatus(201);
        $awb = $response->json('awb_number');
        $this->assertStringStartsWith('TEST', $awb);
    }
}
