<?php

namespace App\Traits;

use Illuminate\Support\Facades\Gate;

trait Authorizable
{
    /**
     * Authorize view any action.
     */
    public function authorizeViewAny(): void
    {
        Gate::authorize('viewAny', $this->repository->getModelClass());
    }

    /**
     * Authorize view action.
     */
    public function authorizeView(int $id): void
    {
        Gate::authorize('view', $this->repository->findOrFail($id));
    }

    /**
     * Authorize create action.
     */
    public function authorizeCreate(): void
    {
        Gate::authorize('create', $this->repository->getModelClass());
    }

    /**
     * Authorize update action.
     */
    public function authorizeUpdate(int $id): void
    {
        Gate::authorize('update', $this->repository->findOrFail($id));
    }

    /**
     * Authorize delete action.
     */
    public function authorizeDelete(int $id): void
    {
        Gate::authorize('delete', $this->repository->findOrFail($id));
    }

    /**
     * Authorize restore action.
     */
    public function authorizeRestore(int $id): void
    {
        Gate::authorize('restore', $this->repository->withTrashed()->findOrFail($id));
    }

    /**
     * Authorize force delete action.
     */
    public function authorizeForceDelete(int $id): void
    {
        Gate::authorize('forceDelete', $this->repository->withTrashed()->findOrFail($id));
    }
}
