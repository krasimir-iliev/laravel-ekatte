<?php

namespace App\Services\Panel;

use App\Exports\Panel\TownHallsExport;
use App\Repositories\Panel\TownHallRepository;
use App\Repositories\Panel\MunicipalityRepository;
use App\Services\Ekatte\EkatteService;
use Astrotomic\Translatable\Locales;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class TownHallService extends EkatteService
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected TownHallRepository $repository,
        protected MunicipalityRepository $municipalityRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('actions', function ($townHall) {
                return view('panel.town-halls.table.actions', compact('townHall'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get form data for create or edit town hall.
     */
    public function getFormData(?int $id = null): array
    {
        $townHall =  $id ? $this->repository->findOrFail($id) : null;

        $municipalities = $this->municipalityRepository->all();

        $locales = app(Locales::class)->all();

        return compact('townHall', 'municipalities', 'locales');
    }

    /**
     * Export town halls data to Excel.
     */
    public function export(array $data): BinaryFileResponse
    {
        return Excel::download(new TownHallsExport, 'town-halls-' . time() . '.xlsx');
    }
}
