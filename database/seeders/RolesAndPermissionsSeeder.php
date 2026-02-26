<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'view transmittals',
            'create transmittals',
            'edit transmittals',
            'delete transmittals',
            'receive transmittals',
            'manage offices',
            'manage users',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Admin: all permissions
        $admin = Role::findOrCreate('Admin');
        $admin->givePermissionTo(Permission::all());

        // User: standard operational permissions
        Role::findOrCreate('User')
            ->givePermissionTo([
                'view transmittals',
                'create transmittals',
                'edit transmittals',
                'delete transmittals',
                'receive transmittals',
                'view reports',
            ]);
    }
}
