<?php

namespace App\Repositories\Panel;

use App\Models\District;
use App\Repositories\Repository;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Builder;

class DistrictRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected District $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        $locale = app(Locales::class)->current();

        return $this->model->with('municipalities')->select(
            'districts.*',
            'district_translations.name as district_name',
            'region_translations.name as region_name',
        )->leftJoin('district_translations', function ($join) use ($locale) {
            $join->on('districts.id', '=', 'district_translations.district_id')
                ->where('district_translations.locale', $locale);
        })->leftJoin('region_translations', function ($join) use ($locale) {
            $join->on('districts.region_id', '=', 'region_translations.region_id')
                ->where('region_translations.locale', $locale);
        });
    }
}
