<?php

namespace App\Repositories\Panel;

use App\Models\Municipality;
use App\Repositories\Repository;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class MunicipalityRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected Municipality $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        $locale = app(Locales::class)->current();

        return $this->model->with('townHalls')->select(
            'municipalities.*',
            'municipality_translations.name as municipality_name',
            'district_translations.name as district_name',
        )->leftJoin('municipality_translations', function ($join) use ($locale) {
            $join->on('municipalities.id', '=', 'municipality_translations.municipality_id')
                ->where('municipality_translations.locale', $locale);
        })->leftJoin('district_translations', function ($join) use ($locale) {
            $join->on('municipalities.district_id', '=', 'district_translations.district_id')
                ->where('district_translations.locale', $locale);
        });
    }

    /**
     * Get all municipalities by district ID.
     */
    public function getAllByDistrictId(int $id): Collection
    {
        return $this->model->where('district_id', $id)->get();
    }
}
