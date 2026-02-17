<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OfficeSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        // Create Admin User (Existing)
        $admin = User::firstOrCreate(
            ['email' => 'admin@dti6.gov.ph'],
            [
                'name' => 'MIS Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => \App\Models\Office::where('code', 'RO6')->first()->id,
            ]
        );
        $admin->assignRole('Super Admin');

        // Create Requested Default Users
        $ro6_id = \App\Models\Office::where('code', 'RO6')->first()->id;

        // 1. Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Default Super Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => $ro6_id,
            ]
        );
        $superAdmin->assignRole('Super Admin');

        // 2. Regional MIS
        $regionalMis = User::firstOrCreate(
            ['email' => 'mis@example.com'],
            [
                'name' => 'Default Regional MIS',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => $ro6_id,
            ]
        );
        $regionalMis->assignRole('Regional MIS');

        // 3. Office Head
        $officeHead = User::firstOrCreate(
            ['email' => 'head@example.com'],
            [
                'name' => 'Default Office Head',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => $ro6_id,
            ]
        );
        $officeHead->assignRole('Office Head');

        // 4. Office Staff
        $officeStaff = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'Default Office Staff',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => $ro6_id,
            ]
        );
        $officeStaff->assignRole('Office Staff');
    }
}
