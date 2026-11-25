<?php

namespace App\Policies;

use App\Models\Settlement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SettlementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.settlements.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Settlement $settlement): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.settlements.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Settlement $settlement): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('panel.settlements.destroy');
    }
}
