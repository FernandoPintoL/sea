<?php

namespace App\Policies;

use App\Models\GaleriaVisitante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GaleriaVisitantePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canIndex(modelo: 'GALERIA_VISITANTE');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GaleriaVisitante $galeriaVisitante): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->canCrear('GALERIA_VISITANTE');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GaleriaVisitante $galeriaVisitante): bool
    {
        return $user->canEditar('GALERIA_VISITANTE');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GaleriaVisitante $galeriaVisitante): bool
    {
        return $user->canEliminar('GALERIA_VISITANTE');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GaleriaVisitante $galeriaVisitante): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GaleriaVisitante $galeriaVisitante): bool
    {
        return $user->isSuperAdmin();
    }
}
