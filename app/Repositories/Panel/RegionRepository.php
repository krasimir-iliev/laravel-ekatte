<?php

namespace App\Repositories\Panel;

use App\Models\Region;
use App\Repositories\Repository;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Builder;

class RegionRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected Region $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        return $this->model->with('districts')->select(
            'regions.*',
            'region_translations.name as region_name',
        )->leftJoin('region_translations', function ($join) {
            $join->on('regions.id', '=', 'region_translations.region_id')
                ->where('region_translations.locale', app(Locales::class)->current());
        });
    }
}
