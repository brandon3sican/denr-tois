<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Models\OfficialStation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionAndStationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables
        OfficialStation::truncate();
        Region::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // DENR Regional Offices
        $regions = [
            [
                'code' => 'NCR',
                'name' => 'National Capital Region',
                'region_center' => 'Metro Manila',
                'address' => 'DENR-NCR Compound, #1515 East Ave., Brgy. Central, Quezon City',
                'contact_number' => '(02) 8920-2252',
                'email' => 'ncr@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'NCR-PENRO-QC',
                        'name' => 'Quezon City PENRO',
                        'address' => 'DENR-NCR Compound, #1515 East Ave., Brgy. Central, Quezon City',
                        'officer_in_charge' => 'Atty. Antonio A. Abawag',
                        'officer_position' => 'PENR Officer',
                    ],
                    [
                        'code' => 'NCR-PENRO-MAKATI',
                        'name' => 'Makati PENRO',
                        'address' => 'DENR-NCR West Field Office, 1515 P. Burgos St., Makati City',
                        'officer_in_charge' => 'Engr. Maribel S. Tingson',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R4A',
                'name' => 'CALABARZON',
                'region_center' => 'Calamba City, Laguna',
                'address' => 'DENR IV-A Regional Center, Brgy. Mayapa, Calamba City, Laguna',
                'contact_number' => '(049) 576-7553',
                'email' => 'calabarzon@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R4A-PENRO-LAGUNA',
                        'name' => 'Laguna PENRO',
                        'address' => 'DENR IV-A, Brgy. Mayapa, Calamba City, Laguna',
                        'officer_in_charge' => 'Atty. Adulfo C. Mascariña',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            // Add more regions as needed
        ];

        foreach ($regions as $regionData) {
            $officialStations = $regionData['official_stations'] ?? [];
            unset($regionData['official_stations']);
            
            $region = Region::create($regionData);
            
            foreach ($officialStations as $station) {
                $station['region_id'] = $region->id;
                $station['is_active'] = true;
                $station['contact_number'] = $region->contact_number;
                $station['email'] = $region->email;
                
                OfficialStation::create($station);
            }
        }
    }
}
