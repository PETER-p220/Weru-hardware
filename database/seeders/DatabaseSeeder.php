<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Create default admin users if they don't exist
        $admin1Email = 'admin@oweruhardware.com';
        if (!User::where('email', $admin1Email)->exists()) {
            $admin1 = User::create([
                'name' => 'Administrator',
                'email' => $admin1Email,
                'tel' => '255123456789',
                'password' => Hash::make('admin123'),
            ]);
            $admin1->assignRole('admin');
            $this->command->info('Created admin user: admin@oweruhardware.com / Password: admin123');
        }

        // Create a new admin user with clear credentials
        $admin2Email = 'admin@oweru.com';
        if (!User::where('email', $admin2Email)->exists()) {
            $admin2 = User::create([
                'name' => 'Admin User',
                'email' => $admin2Email,
                'tel' => '255712345678',
                'password' => Hash::make('OweruAdmin2024!'),
            ]);
            $admin2->assignRole('admin');
            $this->command->info('Created admin user: admin@oweru.com / Password: OweruAdmin2024!');
        }

        // Create a test user if it doesn't exist
        $testEmail = 'test@example.com';
        if (!User::where('email', $testEmail)->exists()) {
            $testUser = User::create([
                'name' => 'Test User',
                'email' => $testEmail,
                'tel' => '255987654321',
                'password' => Hash::make('password'),
            ]);
            $testUser->assignRole('user');
        }
    }
}
