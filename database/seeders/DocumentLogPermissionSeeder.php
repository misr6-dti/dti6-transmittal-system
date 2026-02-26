<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DocumentLogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            'view document-logs',
            'create document-logs',
            'edit document-logs',
            'delete document-logs',
            'receive document-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Admin: All permissions
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $admin->givePermissionTo($permissions);
        }

        // User: All document-log permissions
        $user = Role::where('name', 'User')->first();
        if ($user) {
            $user->givePermissionTo($permissions);
        }
    }
}
