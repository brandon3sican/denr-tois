<?php

namespace Database\Seeders;

use App\Models\DivSecUnit;
use App\Models\Position;
use App\Models\EmploymentStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmployeeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to avoid constraint issues
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables to start fresh
        DB::table('div_sec_units')->truncate();
        DB::table('positions')->truncate();
        DB::table('employment_statuses')->truncate();
        
        // Create sample Divisions/Sections/Units
        $units = [
            ['name' => 'Office of the Regional Executive Director', 'description' => 'RED Office'],
            ['name' => 'Office of the Assistant Regional Director', 'description' => 'ARD Office'],
            ['name' => 'Finance and Administrative Division', 'description' => 'FAD'],
            ['name' => 'Technical Services Division', 'description' => 'TSD'],
            ['name' => 'Conservation and Development Division', 'description' => 'CDD'],
            ['name' => 'Licenses, Patents and Deeds Division', 'description' => 'LPDD'],
            ['name' => 'Environmental Management Bureau', 'description' => 'EMB'],
            ['name' => 'Mines and Geosciences Bureau', 'description' => 'MGB'],
        ];

        foreach ($units as $unit) {
            DB::table('div_sec_units')->insert([
                'name' => $unit['name'],
                'description' => $unit['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create sample Positions
        $positions = [
            ['name' => 'Regional Executive Director', 'salary_grade' => 27, 'description' => 'RED'],
            ['name' => 'Assistant Regional Director', 'salary_grade' => 26, 'description' => 'ARD'],
            ['name' => 'Division Chief', 'salary_grade' => 24, 'description' => 'Division Head'],
            ['name' => 'Supervising Environmental Management Specialist', 'salary_grade' => 24, 'description' => 'SEMS'],
            ['name' => 'Senior Environmental Management Specialist', 'salary_grade' => 22, 'description' => 'Sr. EMS'],
            ['name' => 'Environmental Management Specialist II', 'salary_grade' => 16, 'description' => 'EMS II'],
            ['name' => 'Environmental Management Specialist I', 'salary_grade' => 11, 'description' => 'EMS I'],
            ['name' => 'Administrative Officer V', 'salary_grade' => 18, 'description' => 'Admin Officer V'],
            ['name' => 'Administrative Officer IV', 'salary_grade' => 15, 'description' => 'Admin Officer IV'],
            ['name' => 'Administrative Aide VI', 'salary_grade' => 6, 'description' => 'Admin Aide VI'],
            ['name' => 'Administrative Aide IV', 'salary_grade' => 4, 'description' => 'Admin Aide IV'],
        ];

        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'name' => $position['name'],
                'salary_grade' => $position['salary_grade'],
                'description' => $position['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create sample Employment Statuses
        $statuses = [
            ['name' => 'Permanent', 'is_active' => true, 'description' => 'Regular/permanent employee'],
            ['name' => 'Contract of Service', 'is_active' => true, 'description' => 'COS employee'],
            ['name' => 'Job Order', 'is_active' => true, 'description' => 'JO employee'],
            ['name' => 'Co-Terminus', 'is_active' => true, 'description' => 'Co-terminus with the appointing authority'],
            ['name' => 'Casual', 'is_active' => true, 'description' => 'Casual employee'],
            ['name' => 'Part-Time', 'is_active' => true, 'description' => 'Part-time employee'],
            ['name' => 'Separated', 'is_active' => false, 'description' => 'Former employee'],
            ['name' => 'Retired', 'is_active' => false, 'description' => 'Retired employee'],
        ];

        foreach ($statuses as $status) {
            DB::table('employment_statuses')->insert([
                'name' => $status['name'],
                'description' => $status['description'],
                'is_active' => $status['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
