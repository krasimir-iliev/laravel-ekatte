<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    /**
     * Get model class.
     */
    public function getModelClass(): string
    {
        return $this->model::class;
    }

    /**
     * Get all resources.
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->model->get($columns);
    }

    /**
     * Find resource by ID.
     */
    public function find(int|array $id, array $columns = ['*']): Model|Collection|null
    {
        return $this->model->find($id, $columns);
    }

    /**
     * Find or fail resource by ID.
     */
    public function findOrFail(int|array $id, array $columns = ['*']): Model|Collection
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * Create a new resource.
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update the specified resource.
     */
    public function update(array $data, int $id): Model
    {
        $model = $this->model->findOrFail($id);

        $model->update($data);

        return $model;
    }

    /**
     * Delete a specific resource.
     */
    public function delete(int $id): ?bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * Get the model instance including soft deleted records.
     */
    public function withTrashed(): Builder
    {
        return $this->model->withTrashed();
    }

    /**
     * Restore the specified resource.
     */
    public function restore(int $id): bool
    {
        return $this->withTrashed()->findOrFail($id)->restore();
    }

    /**
     * Force delete the specified resource.
     */
    public function forceDelete(int $id): ?bool
    {
        return $this->withTrashed()->findOrFail($id)->forceDelete();
    }
}
