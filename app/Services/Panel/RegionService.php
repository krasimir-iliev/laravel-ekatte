<?php

namespace App\Services\Panel;

use App\Exports\Panel\RegionsExport;
use App\Repositories\Panel\RegionRepository;
use App\Services\Ekatte\EkatteService;
use Astrotomic\Translatable\Locales;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class RegionService extends EkatteService
{
    /**
     * Create a new service instance.
     */
    public function __construct(protected RegionRepository $repository) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('actions', function ($region) {
                return view('panel.regions.table.actions', compact('region'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get form data for create or edit region.
     */
    public function getFormData(?int $id = null): array
    {
        $region = $id ? $this->repository->findOrFail($id) : null;

        $locales = app(Locales::class)->all();

        return compact('region', 'locales');
    }

    /**
     * Export region data to Excel.
     */
    public function export(array $data): BinaryFileResponse
    {
        return Excel::download(new RegionsExport, 'regions-' . time() . '.xlsx');
    }
}
