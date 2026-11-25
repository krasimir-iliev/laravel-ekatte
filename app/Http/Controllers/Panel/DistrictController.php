<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\District\StoreDistrictRequest;
use App\Http\Requests\Panel\District\UpdateDistrictRequest;
use App\Services\Panel\DistrictService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DistrictController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected DistrictService $districtService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->districtService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->districtService->getDataTable($request->all());
        }

        return view('panel.districts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->districtService->authorizeCreate();

        $data = $this->districtService->getFormData();

        return view('panel.districts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDistrictRequest $request): RedirectResponse
    {
        $this->districtService->authorizeCreate();

        $this->districtService->create($request->validated());

        return redirect()->route('panel.districts.index')
            ->withSuccess(__('District added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->districtService->authorizeUpdate($id);

        $data = $this->districtService->getFormData($id);

        return view('panel.districts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistrictRequest $request, int $id): RedirectResponse
    {
        $this->districtService->authorizeUpdate($id);

        $this->districtService->update($request->validated(), $id);

        return redirect()->route('panel.districts.index')
            ->withSuccess(__('District updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->districtService->authorizeDelete($id);

        return $this->districtService->delete($id);
    }

    /**
     * Export data from storage.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $this->districtService->authorizeViewAny();

        return $this->districtService->export($request->all());
    }
}
