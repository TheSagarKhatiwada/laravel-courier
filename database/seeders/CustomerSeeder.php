<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $hq  = Branch::where('code', 'HQ')->first();
        $del = Branch::where('code', 'DEL')->first();
        $blr = Branch::where('code', 'BLR')->first();

        $customers = [
            [
                'name'      => 'Acme Enterprises',
                'code'      => 'ACME001',
                'email'     => 'accounts@acme.com',
                'phone'     => '+91-9800001111',
                'address'   => '10 Industrial Area',
                'city'      => 'Mumbai',
                'state'     => 'Maharashtra',
                'pincode'   => '400093',
                'branch_id' => $hq->id,
                'credit_limit' => 50000,
                'balance'   => 0,
            ],
            [
                'name'      => 'Global Traders',
                'code'      => 'GLOB002',
                'email'     => 'info@globaltraders.com',
                'phone'     => '+91-9800002222',
                'address'   => '22 Trade Centre',
                'city'      => 'New Delhi',
                'state'     => 'Delhi',
                'pincode'   => '110045',
                'branch_id' => $del->id,
                'credit_limit' => 30000,
                'balance'   => 0,
            ],
            [
                'name'      => 'Tech Solutions Pvt Ltd',
                'code'      => 'TECH003',
                'email'     => 'logistics@techsol.in',
                'phone'     => '+91-9800003333',
                'address'   => '5 Software Park',
                'city'      => 'Bangalore',
                'state'     => 'Karnataka',
                'pincode'   => '560100',
                'branch_id' => $blr->id,
                'credit_limit' => 75000,
                'balance'   => 0,
            ],
            [
                'name'      => 'Sunrise Retail',
                'code'      => 'SUNR004',
                'email'     => 'supply@sunriseretail.com',
                'phone'     => '+91-9800004444',
                'address'   => '8 Market Street',
                'city'      => 'Mumbai',
                'state'     => 'Maharashtra',
                'pincode'   => '400001',
                'branch_id' => $hq->id,
                'credit_limit' => 20000,
                'balance'   => 0,
            ],
            [
                'name'      => 'Blue Ocean Exports',
                'code'      => 'BLUE005',
                'email'     => 'export@blueocean.com',
                'phone'     => '+91-9800005555',
                'address'   => '15 Port Road',
                'city'      => 'New Delhi',
                'state'     => 'Delhi',
                'pincode'   => '110020',
                'branch_id' => $del->id,
                'credit_limit' => 100000,
                'balance'   => 0,
            ],
        ];

        foreach ($customers as $data) {
            Customer::firstOrCreate(['code' => $data['code']], $data);
        }
    }
}
