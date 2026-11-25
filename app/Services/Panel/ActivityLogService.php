<?php

namespace App\Services\Panel;

use App\Repositories\Panel\ActivityLogRepository;
use App\Services\Service;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogService extends Service
{
    /**
     * Create a new service instance.
     */
    public function __construct(protected ActivityLogRepository $repository) {}

    /**
     * Get DataTable response.
     */
    public function getDataTable(array $data): JsonResponse
    {
        return DataTables::eloquent($this->repository->query($data))
            ->editColumn('event', function ($activityLog) {
                return __($activityLog->event);
            })
            ->addColumn('actions', function ($activityLog) {
                return view('panel.activity-logs.table.actions', compact('activityLog'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Get all subject types.
     */
    public function getAllSubjectTypes(): Collection
    {
        return $this->repository->getAllSubjectTypes();
    }

    /**
     * Get all event types.
     */
    public function getAllEvents(): Collection
    {
        return $this->repository->getAllEvents();
    }
}
