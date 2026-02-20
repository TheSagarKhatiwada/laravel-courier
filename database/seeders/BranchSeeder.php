<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            [
                'name'    => 'Head Office',
                'code'    => 'HQ',
                'city'    => 'Mumbai',
                'state'   => 'Maharashtra',
                'address' => '123 Main Street',
                'pincode' => '400001',
                'phone'   => '+91-22-12345678',
                'email'   => 'hq@courier.com',
            ],
            [
                'name'    => 'Delhi Branch',
                'code'    => 'DEL',
                'city'    => 'New Delhi',
                'state'   => 'Delhi',
                'address' => '456 Connaught Place',
                'pincode' => '110001',
                'phone'   => '+91-11-12345678',
                'email'   => 'delhi@courier.com',
            ],
            [
                'name'    => 'Bangalore Branch',
                'code'    => 'BLR',
                'city'    => 'Bangalore',
                'state'   => 'Karnataka',
                'address' => '789 MG Road',
                'pincode' => '560001',
                'phone'   => '+91-80-12345678',
                'email'   => 'blr@courier.com',
            ],
        ];

        foreach ($branches as $data) {
            Branch::firstOrCreate(['code' => $data['code']], $data);
        }
    }
}
