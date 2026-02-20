<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
        $this->user = User::factory()->create();
        $this->user->assignRole('admin');
        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    public function test_can_create_customer(): void
    {
        $branch = Branch::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/customers', [
                'name' => 'ABC Logistics',
                'code' => 'ABC001',
                'email' => 'abc@logistics.com',
                'phone' => '9876543210',
                'branch_id' => $branch->id,
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('code', 'ABC001');
    }

    public function test_can_add_ledger_entry(): void
    {
        $branch = Branch::factory()->create();
        $customer = Customer::factory()->create(['branch_id' => $branch->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson("/api/customers/{$customer->id}/ledger", [
                'type' => 'debit',
                'amount' => 500.00,
                'reference' => 'INV-001',
                'remarks' => 'Invoice for services',
                'transaction_date' => today()->toDateString(),
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('type', 'debit');
    }
}
