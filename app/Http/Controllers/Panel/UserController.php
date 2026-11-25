<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\User\StoreUserRequest;
use App\Http\Requests\Panel\User\UpdateUserRequest;
use App\Services\Panel\UserService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected UserService $userService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->userService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->userService->getDataTable($request->all());
        }

        return view('panel.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->userService->authorizeCreate();

        $data = $this->userService->getFormData();

        return view('panel.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->userService->authorizeCreate();

        $this->userService->create($request->validated());

        return redirect()->route('panel.users.index')
            ->withSuccess(__('User added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->userService->authorizeUpdate($id);

        $data = $this->userService->getFormData($id);

        return view('panel.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $this->userService->authorizeUpdate($id);

        $this->userService->update($request->validated(), $id);

        return redirect()->route('panel.users.index')
            ->withSuccess(__('User updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->userService->authorizeDelete($id);

        return $this->userService->delete($id);
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(int $id): bool
    {
        $this->userService->authorizeRestore($id);

        return $this->userService->restore($id);
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete(int $id): bool
    {
        $this->userService->authorizeForceDelete($id);

        return $this->userService->forceDelete($id);
    }
}
