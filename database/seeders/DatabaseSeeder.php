<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            OfficeSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        // Create Admin User
        $user = User::create([
            'name' => 'MIS Admin',
            'email' => 'admin@dti6.gov.ph',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'office_id' => \App\Models\Office::where('code', 'RO6')->first()->id,
        ]);

        $user->assignRole('Super Admin');
    }
}
