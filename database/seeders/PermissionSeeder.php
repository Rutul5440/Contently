<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define all modules and their actions
        $permissions = [
            'Dashboard' => ['view'],
            'User' => ['add', 'update', 'view', 'delete'],
            'Settings' => ['add', 'update', 'view', 'delete'],
        ];

        // Create Permissions
        foreach ($permissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => strtolower("$module.$action"),
                ]);
            }
        }

        // Optionally: Create Roles
        $roles = ['admin', 'manager', 'user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Optionally: Assign all permissions to admin role
        $admin = Role::where('name', 'admin')->first();
        $admin->syncPermissions(Permission::all());
    }
}
