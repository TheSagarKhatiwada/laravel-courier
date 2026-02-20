<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    public function run(): void
    {
        $hq      = Branch::where('code', 'HQ')->first();
        $del     = Branch::where('code', 'DEL')->first();
        $blr     = Branch::where('code', 'BLR')->first();
        $admin   = User::where('email', 'admin@courier.com')->first();
        $acme    = Customer::where('code', 'ACME001')->first();
        $global  = Customer::where('code', 'GLOB002')->first();
        $tech    = Customer::where('code', 'TECH003')->first();

        $shipments = [
            [
                'branch'          => $hq,
                'customer'        => $acme,
                'sender_name'     => 'Acme Enterprises',
                'sender_phone'    => '+91-9800001111',
                'sender_address'  => '10 Industrial Area',
                'sender_city'     => 'Mumbai',
                'sender_state'    => 'Maharashtra',
                'sender_pincode'  => '400093',
                'receiver_name'   => 'John Doe',
                'receiver_phone'  => '+91-9900001111',
                'receiver_address'=> '50 Park Lane',
                'receiver_city'   => 'New Delhi',
                'receiver_state'  => 'Delhi',
                'receiver_pincode'=> '110001',
                'weight'          => 1.5,
                'pieces'          => 1,
                'content'         => 'Documents',
                'declared_value'  => 500,
                'service_type'    => 'express',
                'payment_mode'    => 'prepaid',
                'status'          => 'delivered',
                'freight_charge'  => 150,
                'total_charge'    => 150,
                'booking_date'    => now()->subDays(10),
                'delivered_at'    => now()->subDays(8),
            ],
            [
                'branch'          => $del,
                'customer'        => $global,
                'sender_name'     => 'Global Traders',
                'sender_phone'    => '+91-9800002222',
                'sender_address'  => '22 Trade Centre',
                'sender_city'     => 'New Delhi',
                'sender_state'    => 'Delhi',
                'sender_pincode'  => '110045',
                'receiver_name'   => 'Jane Smith',
                'receiver_phone'  => '+91-9900002222',
                'receiver_address'=> '20 Lake View',
                'receiver_city'   => 'Bangalore',
                'receiver_state'  => 'Karnataka',
                'receiver_pincode'=> '560001',
                'weight'          => 3.0,
                'pieces'          => 2,
                'content'         => 'Electronics',
                'declared_value'  => 5000,
                'service_type'    => 'standard',
                'payment_mode'    => 'credit',
                'status'          => 'in_transit',
                'freight_charge'  => 200,
                'total_charge'    => 200,
                'booking_date'    => now()->subDays(3),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $blr,
                'customer'        => $tech,
                'sender_name'     => 'Tech Solutions',
                'sender_phone'    => '+91-9800003333',
                'sender_address'  => '5 Software Park',
                'sender_city'     => 'Bangalore',
                'sender_state'    => 'Karnataka',
                'sender_pincode'  => '560100',
                'receiver_name'   => 'Ramesh Kumar',
                'receiver_phone'  => '+91-9900003333',
                'receiver_address'=> '30 Ring Road',
                'receiver_city'   => 'Mumbai',
                'receiver_state'  => 'Maharashtra',
                'receiver_pincode'=> '400001',
                'weight'          => 0.5,
                'pieces'          => 1,
                'content'         => 'Sample Product',
                'declared_value'  => 1000,
                'service_type'    => 'same_day',
                'payment_mode'    => 'cod',
                'cod_amount'      => 1200,
                'status'          => 'out_for_delivery',
                'freight_charge'  => 120,
                'total_charge'    => 180,
                'booking_date'    => now()->subDay(),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $hq,
                'customer'        => $acme,
                'sender_name'     => 'Acme Enterprises',
                'sender_phone'    => '+91-9800001111',
                'sender_address'  => '10 Industrial Area',
                'sender_city'     => 'Mumbai',
                'sender_state'    => 'Maharashtra',
                'sender_pincode'  => '400093',
                'receiver_name'   => 'Priya Patel',
                'receiver_phone'  => '+91-9900004444',
                'receiver_address'=> '7 Green Park',
                'receiver_city'   => 'Bangalore',
                'receiver_state'  => 'Karnataka',
                'receiver_pincode'=> '560002',
                'weight'          => 2.0,
                'pieces'          => 1,
                'content'         => 'Books',
                'declared_value'  => 800,
                'service_type'    => 'standard',
                'payment_mode'    => 'prepaid',
                'status'          => 'booked',
                'freight_charge'  => 130,
                'total_charge'    => 130,
                'booking_date'    => today(),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $del,
                'customer'        => $global,
                'sender_name'     => 'Global Traders',
                'sender_phone'    => '+91-9800002222',
                'sender_address'  => '22 Trade Centre',
                'sender_city'     => 'New Delhi',
                'sender_state'    => 'Delhi',
                'sender_pincode'  => '110045',
                'receiver_name'   => 'Suresh Nair',
                'receiver_phone'  => '+91-9900005555',
                'receiver_address'=> '99 Cross Road',
                'receiver_city'   => 'Mumbai',
                'receiver_state'  => 'Maharashtra',
                'receiver_pincode'=> '400002',
                'weight'          => 5.0,
                'pieces'          => 3,
                'content'         => 'Clothing',
                'declared_value'  => 3000,
                'service_type'    => 'express',
                'payment_mode'    => 'credit',
                'status'          => 'picked',
                'freight_charge'  => 300,
                'total_charge'    => 300,
                'booking_date'    => now()->subDays(2),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $blr,
                'customer'        => $tech,
                'sender_name'     => 'Tech Solutions',
                'sender_phone'    => '+91-9800003333',
                'sender_address'  => '5 Software Park',
                'sender_city'     => 'Bangalore',
                'sender_state'    => 'Karnataka',
                'sender_pincode'  => '560100',
                'receiver_name'   => 'Anita Sharma',
                'receiver_phone'  => '+91-9900006666',
                'receiver_address'=> '44 Hill View',
                'receiver_city'   => 'New Delhi',
                'receiver_state'  => 'Delhi',
                'receiver_pincode'=> '110003',
                'weight'          => 1.0,
                'pieces'          => 1,
                'content'         => 'Mobile Phone',
                'declared_value'  => 20000,
                'service_type'    => 'express',
                'payment_mode'    => 'prepaid',
                'status'          => 'delivered',
                'freight_charge'  => 200,
                'total_charge'    => 200,
                'booking_date'    => now()->subDays(7),
                'delivered_at'    => now()->subDays(5),
            ],
            [
                'branch'          => $hq,
                'customer'        => null,
                'sender_name'     => 'Walk-in Customer',
                'sender_phone'    => '+91-9100001111',
                'sender_address'  => '1 Any Street',
                'sender_city'     => 'Mumbai',
                'sender_state'    => 'Maharashtra',
                'sender_pincode'  => '400001',
                'receiver_name'   => 'Receiver One',
                'receiver_phone'  => '+91-9200001111',
                'receiver_address'=> '2 Other Lane',
                'receiver_city'   => 'Pune',
                'receiver_state'  => 'Maharashtra',
                'receiver_pincode'=> '411001',
                'weight'          => 0.8,
                'pieces'          => 1,
                'content'         => 'Gift Items',
                'declared_value'  => 500,
                'service_type'    => 'standard',
                'payment_mode'    => 'prepaid',
                'status'          => 'returned',
                'freight_charge'  => 80,
                'total_charge'    => 80,
                'booking_date'    => now()->subDays(15),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $del,
                'customer'        => null,
                'sender_name'     => 'Quick Sender',
                'sender_phone'    => '+91-9100002222',
                'sender_address'  => '3 Fast Lane',
                'sender_city'     => 'New Delhi',
                'sender_state'    => 'Delhi',
                'sender_pincode'  => '110001',
                'receiver_name'   => 'Receiver Two',
                'receiver_phone'  => '+91-9200002222',
                'receiver_address'=> '6 Slow Street',
                'receiver_city'   => 'Jaipur',
                'receiver_state'  => 'Rajasthan',
                'receiver_pincode'=> '302001',
                'weight'          => 2.5,
                'pieces'          => 2,
                'content'         => 'Handicrafts',
                'declared_value'  => 1500,
                'service_type'    => 'standard',
                'payment_mode'    => 'cod',
                'cod_amount'      => 1600,
                'status'          => 'in_transit',
                'freight_charge'  => 160,
                'total_charge'    => 220,
                'booking_date'    => now()->subDays(4),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $blr,
                'customer'        => $tech,
                'sender_name'     => 'Tech Solutions',
                'sender_phone'    => '+91-9800003333',
                'sender_address'  => '5 Software Park',
                'sender_city'     => 'Bangalore',
                'sender_state'    => 'Karnataka',
                'sender_pincode'  => '560100',
                'receiver_name'   => 'Vijay Menon',
                'receiver_phone'  => '+91-9900007777',
                'receiver_address'=> '11 Sea View',
                'receiver_city'   => 'Chennai',
                'receiver_state'  => 'Tamil Nadu',
                'receiver_pincode'=> '600001',
                'weight'          => 4.0,
                'pieces'          => 2,
                'content'         => 'Computer Parts',
                'declared_value'  => 15000,
                'service_type'    => 'express',
                'payment_mode'    => 'credit',
                'status'          => 'cancelled',
                'freight_charge'  => 350,
                'total_charge'    => 350,
                'booking_date'    => now()->subDays(6),
                'delivered_at'    => null,
            ],
            [
                'branch'          => $hq,
                'customer'        => $acme,
                'sender_name'     => 'Acme Enterprises',
                'sender_phone'    => '+91-9800001111',
                'sender_address'  => '10 Industrial Area',
                'sender_city'     => 'Mumbai',
                'sender_state'    => 'Maharashtra',
                'sender_pincode'  => '400093',
                'receiver_name'   => 'Deepak Verma',
                'receiver_phone'  => '+91-9900008888',
                'receiver_address'=> '88 Central Park',
                'receiver_city'   => 'Hyderabad',
                'receiver_state'  => 'Telangana',
                'receiver_pincode'=> '500001',
                'weight'          => 7.0,
                'pieces'          => 4,
                'content'         => 'Machine Parts',
                'declared_value'  => 25000,
                'service_type'    => 'standard',
                'payment_mode'    => 'credit',
                'status'          => 'out_for_delivery',
                'freight_charge'  => 450,
                'total_charge'    => 450,
                'booking_date'    => now()->subDays(5),
                'delivered_at'    => null,
            ],
        ];

        foreach ($shipments as $data) {
            $branch   = $data['branch'];
            $customer = $data['customer'];
            unset($data['branch'], $data['customer']);

            $data['branch_id']    = $branch->id;
            $data['customer_id']  = $customer ? $customer->id : null;
            $data['created_by']   = $admin->id;
            $data['awb_number']   = Shipment::generateAwb($branch->code);

            $shipment = Shipment::create($data);

            // Initial tracking entry
            $shipment->trackings()->create([
                'branch_id'  => $branch->id,
                'updated_by' => $admin->id,
                'status'     => 'booked',
                'location'   => $branch->city,
                'remarks'    => 'Shipment booked',
                'tracked_at' => $data['booking_date'],
            ]);

            // Add extra tracking entries for non-booked statuses
            if (in_array($data['status'], ['picked', 'in_transit', 'out_for_delivery', 'delivered', 'returned', 'cancelled'])) {
                $shipment->trackings()->create([
                    'branch_id'  => $branch->id,
                    'updated_by' => $admin->id,
                    'status'     => 'picked',
                    'location'   => $branch->city,
                    'remarks'    => 'Shipment picked up',
                    'tracked_at' => $data['booking_date']->copy()->addHours(2),
                ]);
            }

            if (in_array($data['status'], ['in_transit', 'out_for_delivery', 'delivered', 'returned'])) {
                $shipment->trackings()->create([
                    'branch_id'  => $branch->id,
                    'updated_by' => $admin->id,
                    'status'     => 'in_transit',
                    'location'   => 'Transit Hub',
                    'remarks'    => 'In transit to destination',
                    'tracked_at' => $data['booking_date']->copy()->addDay(),
                ]);
            }

            if (in_array($data['status'], ['out_for_delivery', 'delivered'])) {
                $shipment->trackings()->create([
                    'branch_id'  => $branch->id,
                    'updated_by' => $admin->id,
                    'status'     => 'out_for_delivery',
                    'location'   => $data['receiver_city'],
                    'remarks'    => 'Out for delivery',
                    'tracked_at' => $data['booking_date']->copy()->addDays(2),
                ]);
            }

            if ($data['status'] === 'delivered') {
                $shipment->trackings()->create([
                    'branch_id'  => $branch->id,
                    'updated_by' => $admin->id,
                    'status'     => 'delivered',
                    'location'   => $data['receiver_city'],
                    'remarks'    => 'Delivered successfully',
                    'tracked_at' => $data['delivered_at'],
                ]);
            }
        }
    }
}
