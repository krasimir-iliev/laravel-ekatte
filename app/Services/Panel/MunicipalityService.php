<?php

namespace App\Services\Panel;

use App\Exports\Panel\MunicipalitiesExport;
use App\Repositories\Panel\MunicipalityRepository;
use App\Repositories\Panel\DistrictRepository;
use App\Services\Ekatte\EkatteService;
use Astrotomic\Translatable\Locales;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class MunicipalityService extends EkatteService
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected MunicipalityRepository $repository,
        protected DistrictRepository $districtRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('actions', function ($municipality) {
                return view('panel.municipalities.table.actions', compact('municipality'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get form data for create or edit municipality.
     */
    public function getFormData(?int $id = null): array
    {
        $municipality = $id ? $this->repository->findOrFail($id) : null;

        $districts = $this->districtRepository->all();

        $locales = app(Locales::class)->all();

        return compact('municipality', 'districts', 'locales');
    }

    /**
     * Export municipalities data to Excel.
     */
    public function export(array $data): BinaryFileResponse
    {
        return Excel::download(new MunicipalitiesExport, 'municipalities-' . time() . '.xlsx');
    }
}
