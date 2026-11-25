<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Permission\UpdatePermissionRequest;
use App\Services\Panel\PermissionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected PermissionService $permissionService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->permissionService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->permissionService->getDataTable($request->all());
        }

        return view('panel.permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->permissionService->authorizeUpdate($id);

        $data = $this->permissionService->getEditData($id);

        return view('panel.permissions.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, int $id): RedirectResponse
    {
        $this->permissionService->authorizeUpdate($id);

        $this->permissionService->update($request->validated(), $id);

        return redirect()->route('panel.permissions.index')
            ->withSuccess(__('Permission updated successfully!'));
    }
}
