<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Role\StoreRoleRequest;
use App\Http\Requests\Panel\Role\UpdateRoleRequest;
use App\Services\Panel\RoleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected RoleService $roleService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->roleService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->roleService->getDataTable($request->all());
        }

        return view('panel.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->roleService->authorizeCreate();

        $data = $this->roleService->getFormData();

        return view('panel.roles.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $this->roleService->authorizeCreate();

        $this->roleService->create($request->validated());

        return redirect()->route('panel.roles.index')
            ->withSuccess(__('Role added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->roleService->authorizeUpdate($id);

        $data = $this->roleService->getFormData($id);

        return view('panel.roles.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, int $id): RedirectResponse
    {
        $this->roleService->authorizeUpdate($id);

        $this->roleService->update($request->validated(), $id);

        return redirect()->route('panel.roles.index')
            ->withSuccess(__('Role updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->roleService->authorizeDelete($id);

        return $this->roleService->delete($id);
    }
}
