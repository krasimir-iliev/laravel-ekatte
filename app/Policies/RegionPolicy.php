<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RegionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.regions.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.regions.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Region $region): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.regions.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Region $region): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.regions.destroy')) &&
            $region->districts->isEmpty();
    }
}
