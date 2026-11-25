<?php

namespace App\Repositories\Panel;

use App\Models\ActivityLog;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ActivityLogRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected ActivityLog $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        $activityLogs = $this->model->select('activity_log.*');

        if (!empty($data['subject_type'])) {
            $activityLogs->where('subject_type', $data['subject_type']);
        }

        if (!empty($data['event'])) {
            $activityLogs->where('event', $data['event']);
        }

        return $activityLogs;
    }

    /**
     * Get all subject types.
     */
    public function getAllSubjectTypes(): Collection
    {
        return $this->model->groupBy('subject_type')->get('subject_type');
    }

    /**
     * Get all events.
     */
    public function getAllEvents(): Collection
    {
        return $this->model->groupBy('event')->get('event');
    }
}
