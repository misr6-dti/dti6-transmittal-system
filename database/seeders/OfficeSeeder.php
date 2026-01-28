<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Office;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create all regional and provincial offices (as root offices)
        $mainOffices = [
            ['name' => 'Regional Office VI (RO VI)', 'type' => 'Regional', 'code' => 'RO6', 'parent_id' => null],
            ['name' => 'DTI Iloilo provincial Office', 'type' => 'Provincial', 'code' => 'PO-ILO', 'parent_id' => null],
            ['name' => 'DTI Capiz Provincial Office', 'type' => 'Provincial', 'code' => 'PO-CAP', 'parent_id' => null],
            ['name' => 'DTI Aklan Provincial Office', 'type' => 'Provincial', 'code' => 'PO-AKL', 'parent_id' => null],
            ['name' => 'DTI Antique Provincial Office', 'type' => 'Provincial', 'code' => 'PO-ANT', 'parent_id' => null],
            ['name' => 'DTI Guimaras Provincial Office', 'type' => 'Provincial', 'code' => 'PO-GUI', 'parent_id' => null],
            ['name' => 'DTI Negros Occidental Provincial Office', 'type' => 'Provincial', 'code' => 'PO-NEG', 'parent_id' => null],
        ];

        foreach ($mainOffices as $office) {
            Office::updateOrCreate(['code' => $office['code']], $office);
        }
        
        // Get Regional Office VI to use as parent for divisions
        $regionalOffice = Office::where('code', 'RO6')->first();
        
        if ($regionalOffice) {
            // Create divisions under Regional Office VI
            $divisions = [
                ['name' => 'Office of the Regional Director', 'type' => 'Division', 'code' => 'ORD', 'parent_id' => $regionalOffice->id],
                ['name' => 'Business Development Division', 'type' => 'Division', 'code' => 'BDD', 'parent_id' => $regionalOffice->id],
                ['name' => 'Consumer Protection Division', 'type' => 'Division', 'code' => 'CPD', 'parent_id' => $regionalOffice->id],
                ['name' => 'Finance and Admin Division', 'type' => 'Division', 'code' => 'FAD', 'parent_id' => $regionalOffice->id],
                ['name' => 'Industry Development Division', 'type' => 'Division', 'code' => 'IDD', 'parent_id' => $regionalOffice->id],
            ];
            
            foreach ($divisions as $division) {
                Office::updateOrCreate(['code' => $division['code']], $division);
            }
        }
    }
}
