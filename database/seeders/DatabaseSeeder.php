<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user if it doesn't exist
        if (!User::where('username', 'admin')->exists()) {
            User::create([
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]);
            $this->command->info('Admin user created successfully!');
        }

        // Seed reference data
        $this->call([
            ReferenceDataSeeder::class,
            RegionAndStationSeeder::class,
            EmployeeAndTravelOrderSeeder::class,
        ]);
    }
}
