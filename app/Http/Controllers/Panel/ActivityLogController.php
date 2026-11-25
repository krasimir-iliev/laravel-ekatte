<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Services\Panel\ActivityLogService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected ActivityLogService $activityLogService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $this->activityLogService->authorizeViewAny();

        if ($request->ajax()) {
            return $this->activityLogService->getDataTable($request->all());
        }

        $subjectTypes = $this->activityLogService->getAllSubjectTypes();

        $events = $this->activityLogService->getAllEvents();

        return view('panel.activity-logs.index', compact('subjectTypes', 'events'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $this->activityLogService->authorizeView($id);

        $activityLog = $this->activityLogService->findOrFail($id);

        return view('panel.activity-logs.show', compact('activityLog'));
    }
}
