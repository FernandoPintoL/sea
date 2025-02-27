<?php

namespace App\Policies;

use App\Models\Roles;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canIndex('ROLE');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $roles): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->canCrear('ROLE');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $roles): bool
    {
        return $user->canEditar(modelo: 'ROLE');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $roles): bool
    {
        return $user->canEliminar('ROLE');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $roles): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $roles): bool
    {
        return $user->isSuperAdmin();
    }
}
