<?php

namespace App\Policies;

use App\Models\TownHall;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TownHallPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.town-halls.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.town-halls.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TownHall $townHall): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.town-halls.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TownHall $townHall): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.town-halls.destroy')) &&
            $townHall->settlements->isEmpty();
    }
}
