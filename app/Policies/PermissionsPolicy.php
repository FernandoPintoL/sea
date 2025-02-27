<?php

namespace App\Policies;

use App\Models\Permissions;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canIndex('PERMISSION');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $permissions): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->canCrear('PERMISSION');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $permissions): bool
    {
        return $user->canEditar('PERMISSION');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $permissions): bool
    {
        return $user->canEliminar('PERMISSION');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $permissions): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission $permissions): bool
    {
        return $user->isSuperAdmin();
    }
}
