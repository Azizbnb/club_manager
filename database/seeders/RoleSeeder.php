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
        $adminRole = Role::create(['name' => 'Admin']);
        $userRole = Role::create(['name' => 'Utilisateur simple']);

        // Création des permissions
        Permission::create(['name' => 'manage users']); // ex : CRUD utilisateurs
        Permission::create(['name' => 'view dashboard']); // ex : Accès au dashboard

        // Attribution des permissions au rôle Admin
        $adminRole->givePermissionTo('manage users');
        $adminRole->givePermissionTo('view dashboard');

        // Attribution de la permission "view dashboard" aux utilisateurs simples
        $userRole->givePermissionTo('view dashboard');
    }
}
