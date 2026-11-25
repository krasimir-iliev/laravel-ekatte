<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Settlement\StoreSettlementRequest;
use App\Http\Requests\Panel\Settlement\UpdateSettlementRequest;
use App\Services\Panel\SettlementService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SettlementController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected SettlementService $settlementService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->settlementService->getDataTable($request->all());
        }

        $districts = $this->settlementService->getAllDistricts();

        return view('panel.settlements.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->settlementService->authorizeCreate();

        $data = $this->settlementService->getFormData();

        return view('panel.settlements.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSettlementRequest $request): RedirectResponse
    {
        $this->settlementService->authorizeCreate();

        $this->settlementService->create($request->validated());

        return redirect()->route('panel.settlements.index')
            ->withSuccess(__('Settlement added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->settlementService->authorizeUpdate($id);

        $data = $this->settlementService->getFormData($id);

        return view('panel.settlements.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSettlementRequest $request, int $id): RedirectResponse
    {
        $this->settlementService->authorizeUpdate($id);

        $this->settlementService->update($request->validated(), $id);

        return redirect()->route('panel.settlements.index')
            ->withSuccess(__('Settlement updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->settlementService->authorizeDelete($id);

        return $this->settlementService->delete($id);
    }

    /**
     * Municipalities data results.
     */
    public function dataMunicipalities(Request $request): Collection
    {
        return $this->settlementService->getAllMunicipalitiesByDistrictID($request->input('district_id'));
    }

    /**
     *  Town Halls data results.
     */
    public function dataTownHalls(Request $request): Collection
    {
        return $this->settlementService->getAllTownHallsByMunicipalityID($request->input('municipality_id'));
    }

    /**
     * Export data from storage.
     */
    public function export(Request $request): BinaryFileResponse
    {
        return $this->settlementService->export($request->all());
    }
}
