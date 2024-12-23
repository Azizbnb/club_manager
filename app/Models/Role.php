<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{

    public const ROLE_ADMIN = 'Admin';
    public const ROLE_BUREAU = 'Bureau';
    public const ROLE_USER = 'Membre';

    /**
     * Vérifier si un rôle est réservé aux administrateurs.
     *
     * @return bool
     */
    public function isAdminRole(): bool
    {
        return $this->name === self::ROLE_ADMIN;
    }
    
    /**
     * Relation : Les utilisateurs associés à ce rôle.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id');
    }

    

    /**
     * Vérifier si le rôle est accessible pour un utilisateur donné.
     * Par exemple, empêcher un utilisateur "Bureau" de voir "Admin".
     *
     * @param string $roleName
     * @return bool
     */
    public function isAccessibleForCurrentUser(string $roleName): bool
    {
        $user = auth()->user();

        // Si l'utilisateur est admin, il a accès à tout
        if ($user->hasRole(self::ROLE_ADMIN)) {
            return true;
        }

        // Si l'utilisateur est "Bureau", il ne doit pas voir le rôle "Admin"
        if ($user->hasRole(self::ROLE_BUREAU) && $roleName === self::ROLE_ADMIN) {
            return false;
        }

        // Par défaut, permettre l'accès
        return true;
    }
}
