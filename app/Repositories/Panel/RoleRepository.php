<?php

namespace App\Repositories\Panel;

use App\Models\Role;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

class RoleRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected Role $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        return $this->model->select('roles.*');
    }

    /**
     * Get readonly roles.
     */
    public function getReadonlyRoles(array $ids): array
    {
        return $this->model->whereIn('id', $ids)
            ->where('readonly', 1)
            ->pluck('id')
            ->toArray();
    }

    /**
     * Get modifiable roles.
     */
    public function getModifiableRoles(array $ids): array
    {
        return $this->model->whereIn('id', $ids)
            ->where('readonly', 0)
            ->pluck('id')
            ->toArray();
    }
}
