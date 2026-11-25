<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\TownHall\StoreTownHallRequest;
use App\Http\Requests\Panel\TownHall\UpdateTownHallRequest;
use App\Services\Panel\TownHallService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TownHallController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected TownHallService $townHallService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->townHallService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->townHallService->getDataTable($request->all());
        }

        return view('panel.town-halls.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->townHallService->authorizeCreate();

        $data = $this->townHallService->getFormData();

        return view('panel.town-halls.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTownHallRequest $request): RedirectResponse
    {
        $this->townHallService->authorizeCreate();

        $this->townHallService->create($request->validated());

        return redirect()->route('panel.town-halls.index')
            ->withSuccess(__('Town hall added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->townHallService->authorizeUpdate($id);

        $data = $this->townHallService->getFormData($id);

        return view('panel.town-halls.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTownHallRequest $request, int $id): RedirectResponse
    {
        $this->townHallService->authorizeUpdate($id);

        $this->townHallService->update($request->validated(), $id);

        return redirect()->route('panel.town-halls.index')
            ->withSuccess(__('Town hall updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->townHallService->authorizeDelete($id);

        return $this->townHallService->delete($id);
    }

    /**
     * Export data from storage.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $this->townHallService->authorizeViewAny();

        return $this->townHallService->export($request->all());
    }
}
