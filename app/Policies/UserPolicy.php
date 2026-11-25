<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.users.index');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.users.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.users.edit')) &&
            ($user->id == $model->id || $model->readonly == 0);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.users.destroy')) &&
            $user->id != $model->id && ($user->id == $model->id || $model->readonly == 0);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.users.restore')) &&
            $user->id != $model->id && ($user->id == $model->id || $model->readonly == 0);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return ($user->hasRole('admin') || $user->hasPermissionTo('panel.users.force-delete')) &&
            $user->id != $model->id && ($user->id == $model->id || $model->readonly == 0);
    }
}
