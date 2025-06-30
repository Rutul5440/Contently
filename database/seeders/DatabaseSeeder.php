<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        // User::factory(10)->create();

        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        $adminEmail = 'admin@gmail.com';
        $admin = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Super Admin',
                'phone' => '9999999999',
                'status' => 'active',
                'password' => Hash::make('admin123'),
            ]
            );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
