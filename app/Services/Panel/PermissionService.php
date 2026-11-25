<?php

namespace App\Services\Panel;

use App\Models\Permission;
use App\Repositories\Panel\PermissionRepository;
use App\Repositories\Panel\RoleRepository;
use App\Services\Service;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class PermissionService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected PermissionRepository $repository,
        protected RoleRepository $roleRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('actions', function ($permission) {
                return view('panel.permissions.table.actions', compact('permission'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get edit data for a specific permission.
     */
    public function getEditData(int $id): array
    {
        $permission = $this->repository->findOrFail($id);

        $roles = $this->roleRepository->all();

        return compact('permission', 'roles');
    }

    /**
     * Update the specified permission.
     */
    public function update(array $data, int $id): Permission
    {
        $permission = $this->repository->findOrFail($id);

        $permissionRoles = $permission->roles->pluck('id')->toArray();

        $readonlyRoles = $this->roleRepository->getReadonlyRoles($permissionRoles);

        $modifiableRoles = $this->roleRepository->getModifiableRoles($data['roles'] ?? []);

        $finalRoles = array_merge($readonlyRoles, $modifiableRoles);

        $permission->syncRoles($finalRoles);

        return $permission;
    }
}
