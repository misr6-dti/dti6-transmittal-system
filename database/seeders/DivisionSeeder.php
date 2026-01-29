<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Office;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Regional Office VI to associate with divisions
        $regionalOffice = Office::where('code', 'RO6')->first();
        
        if ($regionalOffice) {
            $divisions = [
                ['name' => 'Office of the Regional Director', 'code' => 'ORD'],
                ['name' => 'Business Development Division', 'code' => 'BDD'],
                ['name' => 'Consumer Protection Division', 'code' => 'CPD'],
                ['name' => 'Finance and Admin Division', 'code' => 'FAD'],
                ['name' => 'Industry Development Division', 'code' => 'IDD'],
            ];
            
            foreach ($divisions as $division) {
                Division::updateOrCreate(
                    ['code' => $division['code']],
                    ['name' => $division['name'], 'office_id' => $regionalOffice->id]
                );
                $this->command->info("Created division: {$division['name']} ({$division['code']})");
            }
            
            $this->command->info('Divisions seeded successfully!');
        } else {
            $this->command->warn('Regional Office VI (RO6) not found. Please create it first.');
        }
    }
}
