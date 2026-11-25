<?php

namespace App\Services\Panel;

use App\Exports\Panel\DistrictsExport;
use App\Repositories\Panel\DistrictRepository;
use App\Repositories\Panel\RegionRepository;
use App\Services\Ekatte\EkatteService;
use Astrotomic\Translatable\Locales;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class DistrictService extends EkatteService
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected DistrictRepository $repository,
        protected RegionRepository $regionRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('actions', function ($district) {
                return view('panel.districts.table.actions', compact('district'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get form data for create or edit district.
     */
    public function getFormData(?int $id = null): array
    {
        $district = $id ? $this->repository->findOrFail($id) : null;

        $regions = $this->regionRepository->all();

        $locales = app(Locales::class)->all();

        return compact('district', 'regions', 'locales');
    }

    /**
     * Export districts data to Excel.
     */
    public function export(array $data): BinaryFileResponse
    {
        return Excel::download(new DistrictsExport, 'districts-' . time() . '.xlsx');
    }
}
