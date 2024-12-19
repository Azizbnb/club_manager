<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $officeRole = Role::firstOrCreate(['name' => 'Bureau']);
        $userRole = Role::firstOrCreate(['name' => 'Utilisateur simple']);

        // Liste des permissions
        $permissions = [
            'add user',
            'edit user',
            'delete user',
            'manage user',
            'view sessions',
            'view documents',
            'view users',
            'view payments',
            'view categories',
            'add categories',
            'edit categories',
            'del categories',
        ];

        // Création des permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Attribution des permissions aux rôles
        $adminRole->syncPermissions([
            'add user',
            'edit user',
            'delete user',
            'manage user',
            'view sessions',
            'view documents',
            'view users',
            'view payments',
            'view categories',
        ]);

        $officeRole->syncPermissions([
            'add user',
            'edit user',
            'view documents',
            'view users',
            'view payments',
            'view categories',
        ]);

        $userRole->syncPermissions([
            'view documents',
        ]);
    }
}
