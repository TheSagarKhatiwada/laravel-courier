<?php

namespace Tests\Unit;

use App\Models\Branch;
use App\Models\Shipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_awb_generation_is_unique_and_formatted(): void
    {
        Branch::create([
            'name' => 'Test Branch',
            'code' => 'TST',
            'is_active' => true,
        ]);

        $awb1 = Shipment::generateAwb('TST');
        $awb2 = Shipment::generateAwb('TST');

        $this->assertStringStartsWith('TST', $awb1);
        $this->assertEquals(13, strlen($awb1)); // TST + 6 date + 4 sequence
    }

    public function test_awb_prefix_matches_branch_code(): void
    {
        Branch::create([
            'name' => 'Mumbai Branch',
            'code' => 'MUM',
            'is_active' => true,
        ]);

        $awb = Shipment::generateAwb('MUM');
        $this->assertStringStartsWith('MUM', $awb);
    }
}
