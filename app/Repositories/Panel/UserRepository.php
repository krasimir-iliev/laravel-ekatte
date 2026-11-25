<?php

namespace App\Repositories\Panel;

use App\Models\User;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected User $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        $query = $this->model->with('roles')->select('users.*');

        if (!empty($data['trashed'])) {
            $query->onlyTrashed();
        }

        $startDate = $data['start_date'] ?? $data['end_date'] ?? null;
        $endDate = $data['end_date'] ?? $data['start_date'] ?? null;

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        return $query;
    }
}
