<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\TravelOrder;
use App\Models\TravelOrderStatus;
use App\Models\EmploymentStatus;
use App\Models\Position;
use App\Models\DivSecUnit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class EmployeeAndTravelOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables
        TravelOrder::truncate();
        Employee::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Get or create required references
        $regularStatus = EmploymentStatus::firstOrCreate(
            ['name' => 'Permanent'],
            ['description' => 'Permanent employee']
        );

        $adminPosition = Position::firstOrCreate(
            ['name' => 'Administrative Officer V'],
            ['description' => 'Administrative Officer V']
        );

        $planningUnit = DivSecUnit::firstOrCreate(
            ['name' => 'Planning and Management Division'],
            ['description' => 'Planning and Management Division']
        );

        $forRecommendationStatus = TravelOrderStatus::firstOrCreate(
            ['name' => 'For Recommendation'],
            ['description' => 'Submitted for recommendation']
        );

        $approvedStatus = TravelOrderStatus::firstOrCreate(
            ['name' => 'Approved'],
            ['description' => 'Approved by the authorized signatory']
        );

        // Create admin employee first
        $adminEmployee = Employee::create([
            'first_name' => 'Admin',
            'middle_name' => 'System',
            'last_name' => 'Administrator',
            'suffix' => null,
            'age' => 35,
            'gender' => 'male',
            'birthdate' => Carbon::now()->subYears(35),
            'date_hired' => Carbon::now()->subYears(5),
            'address' => 'DENR Central Office, Visayas Avenue, Quezon City',
            'contact_num' => '09123456789',
            'position_id' => $adminPosition->id,
            'employment_status_id' => $regularStatus->id,
            'div_sec_unit_id' => $planningUnit->id,
        ]);
        
        // Create or update admin user with employee_id
        $adminUser = \App\Models\User::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => bcrypt('admin123'),
                'is_admin' => true,
                'employee_id' => $adminEmployee->id
            ]
        );
        
        // Update the employee with user_id
        $adminEmployee->user_id = $adminUser->id;
        $adminEmployee->save();

        // Create sample employees with user accounts
        $employees = [
            [
                'first_name' => 'Juan',
                'middle_name' => 'Dela',
                'last_name' => 'Cruz',
                'suffix' => 'Jr',
                'age' => 30,
                'gender' => 'male',
                'birthdate' => Carbon::now()->subYears(30),
                'date_hired' => Carbon::now()->subYears(3),
                'address' => '123 Sample St., Quezon City',
                'contact_num' => '09123456780',
                'position_id' => $adminPosition->id,
                'employment_status_id' => $regularStatus->id,
                'div_sec_unit_id' => $planningUnit->id,
                'user' => [
                    'username' => 'juan.delacruz',
                    'password' => 'password123',
                    'is_admin' => false
                ]
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => 'Santos',
                'last_name' => 'Reyes',
                'suffix' => null,
                'age' => 28,
                'gender' => 'female',
                'birthdate' => Carbon::now()->subYears(28),
                'date_hired' => Carbon::now()->subYears(2),
                'address' => '456 Sample St., Makati City',
                'contact_num' => '09123456781',
                'position_id' => $adminPosition->id,
                'employment_status_id' => $regularStatus->id,
                'div_sec_unit_id' => $planningUnit->id,
                'user' => [
                    'username' => 'maria.reyes',
                    'password' => 'password123',
                    'is_admin' => false
                ]
            ]
        ];

        $createdEmployees = [];
        foreach ($employees as $employeeData) {
            // Extract user data if exists
            $userData = $employeeData['user'] ?? null;
            unset($employeeData['user']);
            
            // Create employee first
            $employee = Employee::create($employeeData);
            $createdEmployees[] = $employee;
            
            // Create user account for employee if user data exists
            if ($userData) {
                // Create or update user with employee_id
                $user = \App\Models\User::updateOrCreate(
                    ['username' => $userData['username']],
                    [
                        'password' => bcrypt($userData['password']),
                        'is_admin' => $userData['is_admin'],
                        'employee_id' => $employee->id
                    ]
                );
                
                // Update employee with user_id
                $employee->user_id = $user->id;
                $employee->save();
            }
        }

        // Get or create required user types
        $requesterType = \App\Models\TravelOrderUserType::firstOrCreate(
            ['name' => 'Requester'],
            ['description' => 'Person who creates the travel order']
        );
        
        $recommenderType = \App\Models\TravelOrderUserType::firstOrCreate(
            ['name' => 'Recommender'],
            ['description' => 'Person who recommends the travel order']
        );
        
        $approverType = \App\Models\TravelOrderUserType::firstOrCreate(
            ['name' => 'Approver'],
            ['description' => 'Person who approves the travel order']
        );

        // Create sample travel orders
        $travelOrders = [
            [
                'region' => 'NCR',
                'address' => 'DENR-NCR Compound, #1515 East Ave., Brgy. Central, Quezon City',
                'date' => Carbon::now(),
                'travel_order_no' => 'TO-' . date('Y') . '-001',
                'employee_id' => $createdEmployees[0]->id,
                'full_name' => $createdEmployees[0]->first_name . ' ' . $createdEmployees[0]->last_name,
                'salary' => 50000.00,
                'position' => 'Administrative Officer V',
                'div_sec_unit' => 'Planning and Management Division',
                'official_station' => 'DENR NCR',
                'destination' => 'DENR Region IV-A, Calamba City, Laguna',
                'departure_date' => Carbon::now()->addDays(7),
                'arrival_date' => Carbon::now()->addDays(9),
                'purpose_of_travel' => 'Attend regional planning workshop',
                'per_diem_expenses' => 2000.00,
                'assistant_or_laborers_allowed' => false,
                'appropriations' => 'Fund 101',
                'remarks' => 'To attend the regional planning workshop',
                'status_id' => $forRecommendationStatus->id,
            ],
            [
                'region' => 'NCR',
                'address' => 'DENR-NCR Compound, #1515 East Ave., Brgy. Central, Quezon City',
                'date' => Carbon::now(),
                'travel_order_no' => 'TO-' . date('Y') . '-002',
                'employee_id' => $createdEmployees[1]->id,
                'full_name' => $createdEmployees[1]->first_name . ' ' . $createdEmployees[1]->last_name,
                'salary' => 48000.00,
                'position' => 'Administrative Officer V',
                'div_sec_unit' => 'Planning and Management Division',
                'official_station' => 'DENR NCR',
                'destination' => 'DENR NCR, Quezon City',
                'departure_date' => Carbon::now()->addDays(5),
                'arrival_date' => Carbon::now()->addDays(5),
                'purpose_of_travel' => 'Field validation and inspection',
                'per_diem_expenses' => 1500.00,
                'assistant_or_laborers_allowed' => true,
                'appropriations' => 'Fund 101',
                'remarks' => 'Field validation of project sites',
                'status_id' => $approvedStatus->id,
            ],
        ];

        foreach ($travelOrders as $travelOrderData) {
            $travelOrder = TravelOrder::create($travelOrderData);
            
            // Create signatories
            if ($travelOrder->status_id == $approvedStatus->id) {
                // For approved travel orders, mark all signatories as signed
                \App\Models\TravelOrderSignatory::create([
                    'travel_order_id' => $travelOrder->id,
                    'employee_id' => $adminEmployee->id,
                    'user_type_id' => $recommenderType->id,
                    'is_signed' => true,
                    'signed_at' => Carbon::now(),
                ]);
                
                \App\Models\TravelOrderSignatory::create([
                    'travel_order_id' => $travelOrder->id,
                    'employee_id' => $adminEmployee->id,
                    'user_type_id' => $approverType->id,
                    'is_signed' => true,
                    'signed_at' => Carbon::now(),
                ]);
            } else {
                // For pending travel orders, only add the requester
                \App\Models\TravelOrderSignatory::create([
                    'travel_order_id' => $travelOrder->id,
                    'employee_id' => $travelOrder->employee_id,
                    'user_type_id' => $requesterType->id,
                    'is_signed' => true,
                    'signed_at' => Carbon::now(),
                ]);
            }
        }

        // The admin user is already updated in the first part of the seeder
    }
}
