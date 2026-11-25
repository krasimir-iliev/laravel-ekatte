<?php

namespace App\Policies;

use App\Models\Municipality;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MunicipalityPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.municipalities.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.municipalities.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Municipality $municipality): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.municipalities.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Municipality $municipality): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.municipalities.destroy')) &&
            $municipality->townHalls->isEmpty();
    }
}
