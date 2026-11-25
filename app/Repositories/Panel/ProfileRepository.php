<?php

namespace App\Repositories\Panel;

use App\Models\User;
use App\Repositories\Repository;

class ProfileRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected User $model) {}
}
