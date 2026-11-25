<?php

namespace App\Services\Panel;

use App\Models\User;
use App\Repositories\Panel\ProfileRepository;
use App\Repositories\Panel\RoleRepository;
use App\Services\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected ProfileRepository $repository,
        protected RoleRepository $roleRepository
    ) {}

    /**
     * Get all roles.
     */
    public function getAllRoles(): Collection
    {
        return $this->roleRepository->all();
    }

    /**
     * Update the profile of a user.
     */
    public function update(array $data, int $id): User
    {
        $profile = $this->repository->findOrFail($id);

        if (empty($data['password'])) {
            unset($data['password']);

            $profile->syncRoles($this->roleRepository->find($data['role'] ?? []));
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $this->repository->update($data, $id);

        return $profile;
    }

    /**
     * Delete the user profile.
     */
    public function delete(int $id): bool
    {
        Auth::logout();

        session()->invalidate();

        session()->regenerateToken();

        return $this->repository->forceDelete($id);
    }
}
