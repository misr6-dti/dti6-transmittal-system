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
        // First, create Regional Office
        $regionalOffice = Office::updateOrCreate(
            ['code' => 'RO6'],
            ['name' => 'Regional Office VI (RO VI)', 'type' => 'Regional', 'parent_id' => null]
        );

        // Create provincial offices with Regional Office as parent
        $provincialOffices = [
            ['name' => 'DTI Iloilo provincial Office', 'type' => 'Provincial', 'code' => 'PO-ILO'],
            ['name' => 'DTI Capiz Provincial Office', 'type' => 'Provincial', 'code' => 'PO-CAP'],
            ['name' => 'DTI Aklan Provincial Office', 'type' => 'Provincial', 'code' => 'PO-AKL'],
            ['name' => 'DTI Antique Provincial Office', 'type' => 'Provincial', 'code' => 'PO-ANT'],
            ['name' => 'DTI Guimaras Provincial Office', 'type' => 'Provincial', 'code' => 'PO-GUI'],
            ['name' => 'DTI Negros Occidental Provincial Office', 'type' => 'Provincial', 'code' => 'PO-NEG'],
        ];

        foreach ($provincialOffices as $office) {
            Office::updateOrCreate(
                ['code' => $office['code']],
                array_merge($office, ['parent_id' => $regionalOffice->id])
            );
        }
    }
}
