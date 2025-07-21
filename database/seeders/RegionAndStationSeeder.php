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
                'code' => 'R1',
                'name' => 'Region I - Ilocos',
                'region_center' => 'San Fernando City, La Union',
                'address' => 'DENR R1, Government Center, Sevilla, San Fernando City, La Union',
                'contact_number' => '(072) 242-0107',
                'email' => 'denrro1@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R1-PENRO-LAUNION',
                        'name' => 'La Union PENRO',
                        'address' => 'DENR PENRO La Union, Sevilla, San Fernando City, La Union',
                        'officer_in_charge' => 'Engr. Jean C. Borromeo',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'CAR',
                'name' => 'Cordillera Administrative Region',
                'region_center' => 'Baguio City',
                'address' => 'DENR-CAR, 80 Diego Silang St., Baguio City',
                'contact_number' => '(074) 422-2564',
                'email' => 'denr.car@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'CAR-PENRO-BENGUET',
                        'name' => 'Benguet PENRO',
                        'address' => 'DENR PENRO Benguet, Wangal, La Trinidad, Benguet',
                        'officer_in_charge' => 'Atty. Cleo D. Sabado-Andrada',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R2',
                'name' => 'Region II - Cagayan Valley',
                'region_center' => 'Tuguegarao City',
                'address' => 'DENR R2, Carig Sur, Tuguegarao City, Cagayan',
                'contact_number' => '(078) 304-1945',
                'email' => 'ro2@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R2-PENRO-CAGAYAN',
                        'name' => 'Cagayan PENRO',
                        'address' => 'DENR PENRO Cagayan, Tuguegarao City',
                        'officer_in_charge' => 'Engr. Mario E. Ancheta',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R3',
                'name' => 'Region III - Central Luzon',
                'region_center' => 'San Fernando City, Pampanga',
                'address' => 'DENR R3, Government Center, Maimpis, San Fernando City, Pampanga',
                'contact_number' => '(045) 455-1726',
                'email' => 'ro3@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R3-PENRO-PAMPANGA',
                        'name' => 'Pampanga PENRO',
                        'address' => 'DENR PENRO Pampanga, San Fernando City',
                        'officer_in_charge' => 'Ms. Celia Estanley',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R4A',
                'name' => 'Region IV-A - CALABARZON',
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
            [
                'code' => 'R4B',
                'name' => 'Region IV-B - MIMAROPA',
                'region_center' => 'Calapan City, Oriental Mindoro',
                'address' => 'DENR IV-B, Brgy. Lalud, Calapan City, Oriental Mindoro',
                'contact_number' => '(043) 288-7236',
                'email' => 'mimaropa@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R4B-PENRO-ORMIN',
                        'name' => 'Oriental Mindoro PENRO',
                        'address' => 'DENR PENRO Or. Mindoro, Calapan City',
                        'officer_in_charge' => 'Ms. Maria Victoria V. Abrera',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R5',
                'name' => 'Region V - Bicol',
                'region_center' => 'Legazpi City',
                'address' => 'DENR V, Regional Government Center, Rawis, Legazpi City',
                'contact_number' => '(052) 482-0376',
                'email' => 'ro5@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R5-PENRO-ALBAY',
                        'name' => 'Albay PENRO',
                        'address' => 'DENR PENRO Albay, Legazpi City',
                        'officer_in_charge' => 'Mr. Jerry R. Arena',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R6',
                'name' => 'Region VI - Western Visayas',
                'region_center' => 'Iloilo City',
                'address' => 'DENR VI, 2nd Floor, CENRO Building, Fort San Pedro, Iloilo City',
                'contact_number' => '(033) 509-7973',
                'email' => 'ro6@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R6-PENRO-ILOILO',
                        'name' => 'Iloilo PENRO',
                        'address' => 'DENR PENRO Iloilo, Iloilo City',
                        'officer_in_charge' => 'Ms. Raquel L. Nerecena',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R7',
                'name' => 'Region VII - Central Visayas',
                'region_center' => 'Cebu City',
                'address' => 'DENR VII, Sudlon, Lahug, Cebu City',
                'contact_number' => '(032) 256-2235',
                'email' => 'ro7@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R7-PENRO-CEBU',
                        'name' => 'Cebu PENRO',
                        'address' => 'DENR PENRO Cebu, Cebu City',
                        'officer_in_charge' => 'Mr. Raul L. Pasoc',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R8',
                'name' => 'Region VIII - Eastern Visayas',
                'region_center' => 'Tacloban City',
                'address' => 'DENR VIII, Government Center, Palo, Leyte',
                'contact_number' => '(053) 323-3154',
                'email' => 'ro8@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R8-PENRO-LEYTE',
                        'name' => 'Leyte PENRO',
                        'address' => 'DENR PENRO Leyte, Tacloban City',
                        'officer_in_charge' => 'Mr. Carlito M. Tuballa',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R9',
                'name' => 'Region IX - Zamboanga Peninsula',
                'region_center' => 'Pagadian City',
                'address' => 'DENR IX, Pettit Barracks, Zamboanga City',
                'contact_number' => '(062) 991-2464',
                'email' => 'ro9@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R9-PENRO-ZAMBOANGA',
                        'name' => 'Zamboanga City PENRO',
                        'address' => 'DENR PENRO Zamboanga City',
                        'officer_in_charge' => 'Ms. Marife M. Absin',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R10',
                'name' => 'Region X - Northern Mindanao',
                'region_center' => 'Cagayan de Oro City',
                'address' => 'DENR X, Masterson Avenue, Upper Balulang, Cagayan de Oro City',
                'contact_number' => '(088) 856-3348',
                'email' => 'ro10@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R10-PENRO-MISOR',
                        'name' => 'Misamis Oriental PENRO',
                        'address' => 'DENR PENRO Misamis Oriental, Cagayan de Oro City',
                        'officer_in_charge' => 'Mr. Teodoro B. Bacolod',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R11',
                'name' => 'Region XI - Davao',
                'region_center' => 'Davao City',
                'address' => 'DENR XI, Davao City',
                'contact_number' => '(082) 224-1106',
                'email' => 'ro11@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R11-PENRO-DAVCITY',
                        'name' => 'Davao City PENRO',
                        'address' => 'DENR PENRO Davao City',
                        'officer_in_charge' => 'Mr. Marcial C. Amaro Jr.',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'R12',
                'name' => 'Region XII - SOCCSKSARGEN',
                'region_center' => 'Koronadal City',
                'address' => 'DENR XII, Koronadal City',
                'contact_number' => '(083) 228-2988',
                'email' => 'ro12@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'R12-PENRO-SCOT',
                        'name' => 'South Cotabato PENRO',
                        'address' => 'DENR PENRO South Cotabato, Koronadal City',
                        'officer_in_charge' => 'Mr. Rosalinda B. Cortez',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'CARAGA',
                'name' => 'Caraga',
                'region_center' => 'Butuan City',
                'address' => 'DENR Caraga, Ambago, Butuan City',
                'contact_number' => '(085) 815-2729',
                'email' => 'caraga@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'CARAGA-PENRO-AGUSAN',
                        'name' => 'Agusan del Norte PENRO',
                        'address' => 'DENR PENRO Agusan del Norte, Butuan City',
                        'officer_in_charge' => 'Mr. Romeo C. Agati',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ],
            [
                'code' => 'BARMM',
                'name' => 'Bangsamoro Autonomous Region in Muslim Mindanao',
                'region_center' => 'Cotabato City',
                'address' => 'BARMM Compound, Cotabato City',
                'contact_number' => '(064) 421-5311',
                'email' => 'barmm@denr.gov.ph',
                'is_active' => true,
                'official_stations' => [
                    [
                        'code' => 'BARMM-PENRO-MAG',
                        'name' => 'Maguindanao PENRO',
                        'address' => 'DENR PENRO Maguindanao, Cotabato City',
                        'officer_in_charge' => 'Mr. Abdul M. Nasser',
                        'officer_position' => 'PENR Officer',
                    ]
                ]
            ]
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
