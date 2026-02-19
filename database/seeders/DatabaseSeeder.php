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
            DocumentLogPermissionSeeder::class,
            DivisionSeeder::class,
        ]);

        $ro6_id = \App\Models\Office::where('code', 'RO6')->first()->id;

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@dti6.gov.ph'],
            [
                'name' => 'MIS Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => $ro6_id,
            ]
        );
        $admin->assignRole('Admin');

        // Create Default User
        $user = User::firstOrCreate(
            ['email' => 'user@dti6.gov.ph'],
            [
                'name' => 'Default User',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'office_id' => $ro6_id,
            ]
        );
        $user->assignRole('User');
    }
}
