<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchApiTest extends TestCase
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

    public function test_can_list_branches(): void
    {
        Branch::factory()->count(3)->create();

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->getJson('/api/branches');

        $response->assertStatus(200);
    }

    public function test_can_create_branch(): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->token)
            ->postJson('/api/branches', [
                'name' => 'Test Branch',
                'code' => 'TST',
                'city' => 'Pune',
                'state' => 'Maharashtra',
                'phone' => '+91-20-12345678',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('code', 'TST');

        $this->assertDatabaseHas('branches', ['code' => 'TST']);
    }
}
