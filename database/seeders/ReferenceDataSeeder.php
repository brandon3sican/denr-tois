<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\DivSecUnit;
use App\Models\EmploymentStatus;
use App\Models\TravelOrderStatus;
use App\Models\TravelOrderUserType;
use Illuminate\Database\Seeder;

class ReferenceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Positions with corresponding salary grades
        $positions = [
            ['name' => 'Administrative Aide I', 'salary' => 12000.00],
            ['name' => 'Administrative Aide II', 'salary' => 13000.00],
            ['name' => 'Administrative Aide III', 'salary' => 14000.00],
            ['name' => 'Administrative Aide IV', 'salary' => 15000.00],
            ['name' => 'Administrative Assistant I', 'salary' => 18000.00],
            ['name' => 'Administrative Assistant II', 'salary' => 20000.00],
            ['name' => 'Administrative Officer I', 'salary' => 25000.00],
            ['name' => 'Administrative Officer II', 'salary' => 28000.00],
            ['name' => 'Administrative Officer III', 'salary' => 32000.00],
            ['name' => 'Administrative Officer IV', 'salary' => 38000.00],
            ['name' => 'Administrative Officer V', 'salary' => 42000.00],
            ['name' => 'Department Secretary', 'salary' => 150000.00],
            ['name' => 'Undersecretary', 'salary' => 120000.00],
            ['name' => 'Assistant Secretary', 'salary' => 100000.00],
            ['name' => 'Director', 'salary' => 80000.00],
            ['name' => 'Assistant Director', 'salary' => 65000.00],
            ['name' => 'Supervising Administrative Officer', 'salary' => 55000.00],
            ['name' => 'Chief Administrative Officer', 'salary' => 48000.00],
        ];

        foreach ($positions as $position) {
            Position::create($position);
        }

        // Seed Division/Section/Units
        $units = [
            ['name' => 'Office of the Secretary'],
            ['name' => 'Office of the Undersecretary for Field Operations'],
            ['name' => 'Office of the Undersecretary for Legal and Administration'],
            ['name' => 'Office of the Assistant Secretary for Finance and Administration'],
            ['name' => 'Office of the Assistant Secretary for Field Operations'],
            ['name' => 'Office of the Assistant Secretary for Policy and Planning'],
            ['name' => 'Biodiversity Management Bureau'],
            ['name' => 'Environmental Management Bureau'],
            ['name' => 'Ecosystems Research and Development Bureau'],
            ['name' => 'Mines and Geosciences Bureau'],
            ['name' => 'Human Resource Development Service'],
            ['name' => 'Finance and Management Service'],
            ['name' => 'Legal Service'],
            ['name' => 'Planning and Policy Service'],
            ['name' => 'Public Affairs Service'],
        ];

        foreach ($units as $unit) {
            DivSecUnit::create($unit);
        }

        // Seed Employment Statuses
        $statuses = [
            ['name' => 'Permanent'],
            ['name' => 'Temporary'],
            ['name' => 'Contract of Service'],
            ['name' => 'Job Order'],
            ['name' => 'Casual'],
            ['name' => 'Co-Terminus'],
            ['name' => 'Co-Terminus with the Appointing Authority'],
            ['name' => 'Coterminous'],
            ['name' => 'Elective'],
            ['name' => 'Part-Time'],
            ['name' => 'Seasonal'],
            ['name' => 'Substitute'],
        ];

        foreach ($statuses as $status) {
            EmploymentStatus::create($status);
        }

        // Seed Travel Order Statuses
        $toStatuses = [
            ['name' => 'Draft', 'description' => 'Initial draft of the travel order'],
            ['name' => 'For Approval', 'description' => 'Submitted for approval'],
            ['name' => 'Approved', 'description' => 'Approved by the authorized signatory'],
            ['name' => 'Disapproved', 'description' => 'Disapproved by the authorized signatory'],
            ['name' => 'Cancelled', 'description' => 'Travel order has been cancelled'],
            ['name' => 'Completed', 'description' => 'Travel has been completed'],
        ];

        foreach ($toStatuses as $status) {
            TravelOrderStatus::create($status);
        }

        // Seed Travel Order User Types
        $userTypes = [
            ['name' => 'Requester', 'description' => 'Person who creates the travel order'],
            ['name' => 'Recommender', 'description' => 'Person who recommends the travel order'],
            ['name' => 'Approver', 'description' => 'Person who approves the travel order'],
            ['name' => 'Noted By', 'description' => 'Person who needs to be informed about the travel order'],
        ];

        foreach ($userTypes as $type) {
            TravelOrderUserType::create($type);
        }
    }
}
