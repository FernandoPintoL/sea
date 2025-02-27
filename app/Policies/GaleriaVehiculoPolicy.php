<?php

namespace App\Policies;

use App\Models\GaleriaVehiculo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GaleriaVehiculoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->canIndex('GALERIA_VEHICULO');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GaleriaVehiculo $galeriaVehiculo): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->canCrear('GALERIA_VEHICULO');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GaleriaVehiculo $galeriaVehiculo): bool
    {
        return $user->canEditar('GALERIA_VEHICULO');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GaleriaVehiculo $galeriaVehiculo): bool
    {
        return $user->canEliminar('GALERIA_VEHICULO');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GaleriaVehiculo $galeriaVehiculo): bool
    {
        return $user->isSuperAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GaleriaVehiculo $galeriaVehiculo): bool
    {
        return $user->isSuperAdmin();
    }
}
