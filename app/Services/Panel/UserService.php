<?php

namespace App\Services\Panel;

use App\Models\User;
use App\Repositories\Panel\RoleRepository;
use App\Repositories\Panel\UserRepository;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected UserRepository $repository,
        protected RoleRepository $roleRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('roles', function ($user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->filterColumn('roles', function ($query, $keyword) {
                $query->whereRelation('roles', 'name', 'like', "%{$keyword}%");
            })
            ->addColumn('actions', function ($user) {
                return view('panel.users.table.actions', compact('user'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get form data for create or edit user.
     */
    public function getFormData(?int $id = null): array
    {
        $user = $id ? $this->repository->findOrFail($id) : null;

        $roles = $this->roleRepository->all();

        return compact('user', 'roles');
    }

    /**
     * Create a new user.
     */
    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->repository->create($data);

        $user->assignRole($this->roleRepository->find($data['role'] ?? []));

        return $user;
    }

    /**
     * Update the specified user.
     */
    public function update(array $data, int $id): User
    {
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user = $this->repository->update($data, $id);

        $user->syncRoles($this->roleRepository->find($data['role'] ?? []));

        return $user;
    }
}
