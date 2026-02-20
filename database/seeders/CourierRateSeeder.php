<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\CourierRate;
use Illuminate\Database\Seeder;

class CourierRateSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();

        $serviceRates = [
            'standard' => [
                'base_weight'             => 0.5,
                'base_price'              => 50.00,
                'additional_weight_price' => 20.00,
                'fuel_surcharge_pct'      => 5.00,
                'cod_charge_pct'          => 2.00,
            ],
            'express' => [
                'base_weight'             => 0.5,
                'base_price'              => 100.00,
                'additional_weight_price' => 40.00,
                'fuel_surcharge_pct'      => 7.50,
                'cod_charge_pct'          => 2.00,
            ],
            'same_day' => [
                'base_weight'             => 0.5,
                'base_price'              => 200.00,
                'additional_weight_price' => 80.00,
                'fuel_surcharge_pct'      => 10.00,
                'cod_charge_pct'          => 2.00,
            ],
        ];

        foreach ($branches as $branch) {
            foreach ($serviceRates as $serviceType => $rates) {
                CourierRate::firstOrCreate(
                    ['branch_id' => $branch->id, 'service_type' => $serviceType],
                    array_merge($rates, ['is_active' => true])
                );
            }
        }
    }
}
