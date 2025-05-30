<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define guard_name
        $guard = 'web';

        // Create roles with guard_name
        $admin = Role::create(['name' => 'admin', 'guard_name' => $guard]);
        $reservations = Role::create(['name' => 'reservations', 'guard_name' => $guard]);
        $operations = Role::create(['name' => 'operations', 'guard_name' => $guard]);
        $accounts = Role::create(['name' => 'accounts', 'guard_name' => $guard]);

        // Create permissions with guard_name
        $permissions = [
            'make-quotations',
            'generate-vouchers',
            // New permissions
            'manage-customer-data',
            'manage-hotels',
            'manage-routes',
            'manage-drivers',
            'manage-guides',
            'manage-markets',
            'manage-currencies',
            'manage-room-categories',
            'manage-room-types',
            'manage-pax-slabs',
            'manage-vehicle-types',
            'manage-markup-value',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => $guard]);
        }

        // Assign permissions to roles
        $reservations->givePermissionTo(['make-quotations', 'make-reservations', 'generate-vouchers']);
        $operations->givePermissionTo(['upload-confirmed-tours', 'generate-vouchers']);
        $accounts->givePermissionTo(['view-accounts']);
        $admin->givePermissionTo(Permission::all());
    }
}
