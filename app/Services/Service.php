<?php

namespace App\Services;

use App\Traits\Authorizable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Service
{
    use Authorizable;

    /**
     * Find or fail resource by ID.
     */
    public function findOrFail(int|array $id, array $columns = ['*']): Model|Collection
    {
        return $this->repository->findOrFail($id, $columns);
    }

    /**
     * Create a new resource.
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * Update the specified resource.
     */
    public function update(array $data, int $id): Model
    {
        return $this->repository->update($data, $id);
    }

    /**
     * Delete the specified resource.
     */
    public function delete(int $id): ?bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Restore the specified resource.
     */
    public function restore(int $id): bool
    {
        return $this->repository->restore($id);
    }

    /**
     * Force delete the specified resource.
     */
    public function forceDelete(int $id): ?bool
    {
        return $this->repository->forceDelete($id);
    }
}
