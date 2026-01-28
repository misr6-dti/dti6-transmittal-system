<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeRegionalDivisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the Regional Office VI (RO VI) as parent
        $regionalOffice = Office::where('code', 'RO6')->first();

        if (!$regionalOffice) {
            $this->command->warn('Regional Office VI (RO6) not found. Please create it first.');
            return;
        }

        $divisions = [
            [
                'name' => 'Office of the Regional Director',
                'code' => 'ORD',
                'type' => 'Unit',
                'parent_id' => $regionalOffice->id,
            ],
            [
                'name' => 'Business Development Division',
                'code' => 'BDD',
                'type' => 'Unit',
                'parent_id' => $regionalOffice->id,
            ],
            [
                'name' => 'Consumer Protection Division',
                'code' => 'CPD',
                'type' => 'Unit',
                'parent_id' => $regionalOffice->id,
            ],
            [
                'name' => 'Finance and Admin Division',
                'code' => 'FAD',
                'type' => 'Unit',
                'parent_id' => $regionalOffice->id,
            ],
            [
                'name' => 'Industry Development Division',
                'code' => 'IDD',
                'type' => 'Unit',
                'parent_id' => $regionalOffice->id,
            ],
        ];

        foreach ($divisions as $division) {
            // Check if division already exists to avoid duplicates
            if (!Office::where('code', $division['code'])->exists()) {
                Office::create($division);
                $this->command->info("Created division: {$division['name']} ({$division['code']})");
            } else {
                $this->command->warn("Division {$division['code']} already exists. Skipping...");
            }
        }

        $this->command->info('Regional divisions seeded successfully!');
    }
}
