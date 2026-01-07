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
        $offices = [
            ['name' => 'Regional Office VI (RO VI)', 'type' => 'Regional', 'code' => 'RO6'],
            ['name' => 'DTI Iloilo provincial Office', 'type' => 'Provincial', 'code' => 'PO-ILO'],
            ['name' => 'DTI Capiz Provincial Office', 'type' => 'Provincial', 'code' => 'PO-CAP'],
            ['name' => 'DTI Aklan Provincial Office', 'type' => 'Provincial', 'code' => 'PO-AKL'],
            ['name' => 'DTI Antique Provincial Office', 'type' => 'Provincial', 'code' => 'PO-ANT'],
            ['name' => 'DTI Guimaras Provincial Office', 'type' => 'Provincial', 'code' => 'PO-GUI'],
            ['name' => 'DTI Negros Occidental Provincial Office', 'type' => 'Provincial', 'code' => 'PO-NEG'],
        ];

        foreach ($offices as $office) {
            Office::updateOrCreate(['code' => $office['code']], $office);
        }
    }
}
