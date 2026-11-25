<?php

namespace App\Repositories\Panel;

use App\Models\Permission;
use App\Repositories\Repository;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Builder;

class PermissionRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected Permission $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        return $this->model->select(
            'permissions.*',
            'permission_translations.display_name as display_name',
        )->join('permission_translations', function ($join) {
            $join->on('permissions.id', '=', 'permission_translations.permission_id')
                ->where('permission_translations.locale', app(Locales::class)->current());
        });
    }
}
