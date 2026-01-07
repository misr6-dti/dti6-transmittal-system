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

        // create roles and assign existing permissions
        $role = Role::findOrCreate('Super Admin');
        $role->givePermissionTo(Permission::all());

        Role::findOrCreate('Office Head')
            ->givePermissionTo(['view transmittals', 'receive transmittals', 'view reports']);

        Role::findOrCreate('Office Staff')
            ->givePermissionTo(['view transmittals', 'create transmittals', 'receive transmittals']);
            
        Role::findOrCreate('Regional MIS')
            ->givePermissionTo(Permission::all());
    }
}
