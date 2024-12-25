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
        $userRole = Role::firstOrCreate(['name' => 'Membre']);

        // Liste des permissions
        $permissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',
            'view dashboard',
            'view sessions',
            'view own documents',
            'view all documents',
            'create documents',
            'edit documents',
            'delete documents',
            'manage documents',
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',
            'manage payments',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'manage categories',
        ];

        // Création des permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Attribution des permissions aux rôles
        $adminRole->syncPermissions([
            'view users',
            'create users',
            'edit users',
            'delete users',
            'manage users',
            'view dashboard',
            'view sessions',
            'view all documents',
            'create documents',
            'edit documents',
            'delete documents',
            'manage documents',
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',
            'manage payments',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'manage categories',
        ]);

        $officeRole->syncPermissions([
            'view dashboard',
            'view users',
            'create users',
            'edit users',
            'view all documents',
            'create documents',
            'create payments',
            'edit documents',
            'view payments',
            'edit payments',
            'view categories',
        ]);

        $userRole->syncPermissions([
            'view dashboard',
            'view own documents',
            'create documents',
        ]);
    }
}
