<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use App\Models\Position;
use App\Models\DivSecUnit;
use App\Models\EmploymentStatus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get references
        $positions = Position::all();
        $units = DivSecUnit::all();
        $statuses = EmploymentStatus::all();

        // Create admin user and employee if not exists
        if (!User::where('username', 'admin')->exists()) {
            // First create the admin employee
            $adminEmployee = Employee::create([
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'middle_name' => 'A',
                'suffix' => null,
                'age' => 35,
                'gender' => 'Male',
                'address' => 'DENR Central Office, Visayas Avenue, Quezon City',
                'contact_num' => '09123456789',
                'birthdate' => now()->subYears(35),
                'date_hired' => now()->subYears(5),
                'position_id' => $positions->firstWhere('name', 'like', '%Director%') ?: $positions->first()->id,
                'div_sec_unit_id' => $units->first()->id,
                'employment_status_id' => $statuses->firstWhere('name', 'like', '%Permanent%') ?: $statuses->first()->id,
                'created_at' => now()->subYears(5),
            ]);

            // Then create the admin user linked to the admin employee
            User::create([
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'employee_id' => $adminEmployee->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
