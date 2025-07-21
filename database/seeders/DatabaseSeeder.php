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
        // Seed reference data
        $this->call([
            ReferenceDataSeeder::class,
            RegionAndStationSeeder::class,
            SampleDataSeeder::class,
        ]);
    }
}
