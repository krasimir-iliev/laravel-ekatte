<?php

namespace App\Policies;

use App\Models\District;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DistrictPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.districts.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.districts.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, District $district): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.districts.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, District $district): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.districts.destroy')) &&
            $district->municipalities->isEmpty();
    }
}
