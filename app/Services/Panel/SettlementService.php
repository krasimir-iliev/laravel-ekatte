<?php

namespace App\Services\Panel;

use App\Exports\Panel\SettlementsExport;
use App\Repositories\Panel\DistrictRepository;
use App\Repositories\Panel\MunicipalityRepository;
use App\Repositories\Panel\SettlementKindRepository;
use App\Repositories\Panel\SettlementRepository;
use App\Repositories\Panel\TownHallRepository;
use App\Services\Ekatte\EkatteService;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;

class SettlementService extends EkatteService
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected SettlementRepository $repository,
        protected SettlementKindRepository $settlementKindRepository,
        protected DistrictRepository $districtRepository,
        protected MunicipalityRepository $municipalityRepository,
        protected TownHallRepository $townHallRepository
    ) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->addColumn('actions', function ($settlement) {
                return view('panel.settlements.table.actions', compact('settlement'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get all districts.
     */
    public function getAllDistricts(): Collection
    {
        return $this->districtRepository->all();
    }

    /**
     * Get all municipalities by district ID.
     */
    public function getAllMunicipalitiesByDistrictID(?int $id): Collection
    {
        return $id ? $this->municipalityRepository->getAllByDistrictID($id) : new Collection();
    }

    /**
     * Get all town halls by municipality ID.
     */
    public function getAllTownHallsByMunicipalityID(?int $id): Collection
    {
        return $id ? $this->townHallRepository->getAllByMunicipalityID($id) : new Collection();
    }

    /**
     * Get form data for create or edit settlement.
     */
    public function getFormData(?int $id = null): array
    {
        $settlement = $id ? $this->repository->show($id) : null;

        $settlementKinds = $this->settlementKindRepository->all();

        $locales = app(Locales::class)->all();

        $districts = $this->getAllDistricts();

        $municipalities = $this->getAllMunicipalitiesByDistrictID(session()->getOldInput('district_id', $settlement?->townHall?->municipality?->district_id));

        $townHalls = $this->getAllTownHallsByMunicipalityID(session()->getOldInput('municipality_id', $settlement?->townHall?->municipality_id));

        return compact('settlement', 'settlementKinds', 'locales', 'districts', 'municipalities', 'townHalls');
    }

    /**
     * Export settlements data to Excel.
     */
    public function export(array $data): BinaryFileResponse
    {
        return Excel::download(new SettlementsExport, 'settlements-' . time() . '.xlsx');
    }
}
