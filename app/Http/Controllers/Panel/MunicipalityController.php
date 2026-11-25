<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Municipality\StoreMunicipalityRequest;
use App\Http\Requests\Panel\Municipality\UpdateMunicipalityRequest;
use App\Services\Panel\MunicipalityService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MunicipalityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected MunicipalityService $municipalityService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->municipalityService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->municipalityService->getDataTable($request->all());
        }

        return view('panel.municipalities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $this->municipalityService->authorizeCreate();

        $data = $this->municipalityService->getFormData();

        return view('panel.municipalities.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMunicipalityRequest $request): RedirectResponse
    {
        $this->municipalityService->authorizeCreate();

        $this->municipalityService->create($request->validated());

        return redirect()->route('panel.municipalities.index')
            ->withSuccess(__('Municipality added successfully!'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $this->municipalityService->authorizeUpdate($id);

        $data = $this->municipalityService->getFormData($id);

        return view('panel.municipalities.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMunicipalityRequest $request, int $id): RedirectResponse
    {
        $this->municipalityService->authorizeUpdate($id);

        $this->municipalityService->update($request->validated(), $id);

        return redirect()->route('panel.municipalities.index')
            ->withSuccess(__('Municipality updated successfully!'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): bool
    {
        $this->municipalityService->authorizeDelete($id);

        return $this->municipalityService->delete($id);
    }

    /**
     * Export data from storage.
     */
    public function export(Request $request): BinaryFileResponse
    {
        $this->municipalityService->authorizeViewAny();

        return $this->municipalityService->export($request->all());
    }
}
