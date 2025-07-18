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

        // Create sample employees with matching user accounts (one-to-one)
        $employees = [
            ['first_name' => 'Juan', 'last_name' => 'Dela Cruz', 'gender' => 'Male', 'position' => 'Forester', 'unit' => 'FMS', 'status' => 'Permanent'],
            ['first_name' => 'Maria', 'last_name' => 'Santos', 'gender' => 'Female', 'position' => 'Biologist', 'unit' => 'BMB', 'status' => 'Permanent'],
            ['first_name' => 'Jose', 'last_name' => 'Reyes', 'gender' => 'Male', 'position' => 'Geologist', 'unit' => 'MGB', 'status' => 'Contractual'],
            ['first_name' => 'Ana', 'last_name' => 'Bautista', 'gender' => 'Female', 'position' => 'Environmental Planner', 'unit' => 'EMB', 'status' => 'Permanent'],
            ['first_name' => 'Pedro', 'last_name' => 'Cruz', 'gender' => 'Male', 'position' => 'Forester', 'unit' => 'PENRO', 'status' => 'Job Order'],
            ['first_name' => 'Sofia', 'last_name' => 'Ramos', 'gender' => 'Female', 'position' => 'Chemist', 'unit' => 'EMB', 'status' => 'Permanent'],
            ['first_name' => 'Miguel', 'last_name' => 'Gonzales', 'gender' => 'Male', 'position' => 'Forester', 'unit' => 'CENRO', 'status' => 'Permanent'],
            ['first_name' => 'Carmen', 'last_name' => 'Lopez', 'gender' => 'Female', 'position' => 'Administrative Officer', 'unit' => 'FMS', 'status' => 'Permanent'],
            ['first_name' => 'Antonio', 'last_name' => 'Mendoza', 'gender' => 'Male', 'position' => 'Engineer', 'unit' => 'MGB', 'status' => 'Contractual'],
            ['first_name' => 'Lourdes', 'last_name' => 'Fernandez', 'gender' => 'Female', 'position' => 'Biologist', 'unit' => 'BMB', 'status' => 'Permanent'],
        ];

        // Create employees with user accounts
        foreach ($employees as $employee) {
            $position = $positions->firstWhere('name', 'like', '%' . $employee['position'] . '%') ?? $positions->random();
            $unit = $units->firstWhere('name', 'like', '%' . $employee['unit'] . '%') ?? $units->random();
            $status = $statuses->firstWhere('name', $employee['status']) ?? $statuses->first();
            
            $birthdate = now()->subYears(rand(25, 55))->subMonths(rand(0, 11))->subDays(rand(0, 30));
            $dateHired = now()->subYears(rand(1, 10))->subMonths(rand(0, 11))->subDays(rand(0, 30));
            $createdAt = now()->subMonths(rand(0, 12))->subDays(rand(0, 30));
            
            // Create employee
            $emp = Employee::create([
                'first_name' => $employee['first_name'],
                'last_name' => $employee['last_name'],
                'middle_name' => $this->getRandomMiddleInitial(),
                'suffix' => rand(1, 10) === 1 ? ['Jr.', 'Sr.', 'III', 'IV'][array_rand(['Jr.', 'Sr.', 'III', 'IV'])] : null,
                'age' => now()->diffInYears($birthdate),
                'gender' => $employee['gender'],
                'address' => $this->getRandomAddress(),
                'contact_num' => '09' . rand(100000000, 999999999),
                'birthdate' => $birthdate,
                'date_hired' => $dateHired,
                'position_id' => $position->id,
                'div_sec_unit_id' => $unit->id,
                'employment_status_id' => $status->id,
                'created_at' => $createdAt,
            ]);

            // Generate username (first initial + last name, lowercase, no special chars)
            $username = strtolower(substr($employee['first_name'], 0, 1) . preg_replace('/[^a-zA-Z0-9]/', '', $employee['last_name']));
            
            // Ensure username is unique
            $counter = 1;
            $originalUsername = $username;
            while (User::where('username', $username)->exists()) {
                $username = $originalUsername . $counter;
                $counter++;
            }
            
            // Create user account for this employee
            User::create([
                'username' => $username,
                'password' => Hash::make('password123'), // Default password
                'is_admin' => false,
                'employee_id' => $emp->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }

    /**
     * Generate a random middle initial
     */
    private function getRandomMiddleInitial(): string
    {
        $middleInitials = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
                          'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        return $middleInitials[array_rand($middleInitials)];
    }
    
    private function getRandomAddress(): string
    {
        $streets = ['Rizal', 'Mabini', 'Bonifacio', 'Luna', 'Roxas', 'Aguinaldo', 'Quezon', 'Osmeña', 'MacArthur', 'Sikatuna'];
        $barangays = ['Poblacion', 'San Jose', 'San Isidro', 'San Roque', 'Sta. Maria', 'Sto. Niño', 'San Miguel', 'San Antonio', 'San Pedro', 'San Nicolas'];
        $cities = ['Manila', 'Quezon City', 'Caloocan', 'Las Piñas', 'Makati', 'Malabon', 'Mandaluyong', 'Marikina', 'Muntinlupa', 'Navotas', 'Parañaque', 'Pasay', 'Pasig', 'San Juan', 'Taguig', 'Valenzuela'];
        
        return rand(1, 999) . ' ' . $streets[array_rand($streets)] . ' St., ' . 
               'Brgy. ' . $barangays[array_rand($barangays)] . ', ' . 
               $cities[array_rand($cities)] . ' City, Metro Manila';
    }
}
