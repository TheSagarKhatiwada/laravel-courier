<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage-branches',
            'manage-users',
            'manage-customers',
            'create-shipments',
            'view-shipments',
            'update-shipments',
            'manage-rates',
            'track-shipments',
            'manage-employees',
            'manage-hrms',
            'manage-tasks',
            'view-reports',
            'manage-api-keys',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $roles = [
            'super_admin' => $permissions,
            'admin' => [
                'manage-branches', 'manage-users', 'manage-customers',
                'create-shipments', 'view-shipments', 'update-shipments',
                'manage-rates', 'track-shipments', 'manage-employees',
                'manage-hrms', 'manage-tasks', 'view-reports', 'manage-api-keys',
            ],
            'manager' => [
                'manage-customers', 'create-shipments', 'view-shipments',
                'update-shipments', 'track-shipments', 'manage-employees',
                'manage-hrms', 'manage-tasks', 'view-reports',
            ],
            'operator' => [
                'create-shipments', 'view-shipments', 'update-shipments', 'track-shipments',
            ],
            'driver' => [
                'view-shipments', 'update-shipments', 'track-shipments',
            ],
            'customer' => [
                'create-shipments', 'view-shipments', 'track-shipments',
            ],
            'api_partner' => [
                'create-shipments', 'view-shipments', 'track-shipments', 'manage-api-keys',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }
    }
}
