<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Region\StoreRegionRequest;
use App\Http\Requests\Panel\Region\UpdateRegionRequest;
use App\Services\Panel\RegionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class RegionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected RegionService $regionService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->regionService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->regionService->getDataTable($request->all());
        }

        return view('panel.regions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->regionService->authorizeCreate();

        $data = $this->regionService->getFormData();

        return view('panel.regions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request): RedirectResponse
    {
        $this->regionService->authorizeCreate();

        $this->regionService->create($request->validated());

        return redirect()->route('panel.regions.index')
            ->withSuccess(__('Region added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->regionService->authorizeUpdate($id);

        $data = $this->regionService->getFormData($id);

        return view('panel.regions.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegionRequest $request, int $id): RedirectResponse
    {
        $this->regionService->authorizeUpdate($id);

        $this->regionService->update($request->validated(), $id);

        return redirect()->route('panel.regions.index')
            ->withSuccess(__('Region updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->regionService->authorizeDelete($id);

        return $this->regionService->delete($id);
    }

    /**
     * Export data from storage.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $this->regionService->authorizeViewAny();

        return $this->regionService->export($request->all());
    }
}
