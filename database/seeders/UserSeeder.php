<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $hq  = Branch::where('code', 'HQ')->first();
        $del = Branch::where('code', 'DEL')->first();
        $blr = Branch::where('code', 'BLR')->first();

        $users = [
            [
                'name'      => 'Super Admin',
                'email'     => 'superadmin@courier.com',
                'password'  => Hash::make('password'),
                'branch_id' => $hq->id,
                'role'      => 'super_admin',
            ],
            [
                'name'      => 'Admin User',
                'email'     => 'admin@courier.com',
                'password'  => Hash::make('password'),
                'branch_id' => $hq->id,
                'role'      => 'admin',
            ],
            [
                'name'      => 'Manager User',
                'email'     => 'manager@courier.com',
                'password'  => Hash::make('password'),
                'branch_id' => $del->id,
                'role'      => 'manager',
            ],
            [
                'name'      => 'Operator User',
                'email'     => 'operator@courier.com',
                'password'  => Hash::make('password'),
                'branch_id' => $blr->id,
                'role'      => 'operator',
            ],
            [
                'name'      => 'Customer User',
                'email'     => 'customer@courier.com',
                'password'  => Hash::make('password'),
                'branch_id' => $hq->id,
                'role'      => 'customer',
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::firstOrCreate(['email' => $data['email']], $data);
            $user->syncRoles([$role]);
        }
    }
}
