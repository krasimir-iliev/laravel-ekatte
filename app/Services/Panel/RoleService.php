<?php

namespace App\Services\Panel;

use App\Models\Role;
use App\Repositories\Panel\PermissionRepository;
use App\Repositories\Panel\RoleRepository;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class RoleService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected RoleRepository $repository,
        protected PermissionRepository $permissionRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->editColumn('readonly', function ($role) {
                return view('panel.roles.table.readonly', compact('role'));
            })
            ->addColumn('actions', function ($role) {
                return view('panel.roles.table.actions', compact('role'));
            })
            ->rawColumns(['readonly', 'actions'])
            ->make(true);
    }

    /**
     * Get form data for create or edit role.
     */
    public function getFormData(?int $id = null): array
    {
        $role = $id ? $this->repository->findOrFail($id) : null;

        $permissions = $this->permissionRepository->all();

        return compact('role', 'permissions');
    }

    /**
     * Create a new role.
     */
    public function create(array $data): Role
    {
        $role = $this->repository->create([
            'name' => $data['name'],
        ]);

        $role->syncPermissions($this->permissionRepository->find($data['permissions'] ?? []));

        return $role;
    }

    /**
     * Update the specified role.
     */
    public function update(array $data, int $id): Role
    {
        $role = $this->repository->update([
            'name' => $data['name'],
        ], $id);

        $role->syncPermissions($this->permissionRepository->find($data['permissions'] ?? []));

        return $role;
    }
}
