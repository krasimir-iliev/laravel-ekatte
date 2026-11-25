<?php

namespace App\Repositories\Panel;

use App\Models\TownHall;
use App\Repositories\Repository;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TownHallRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected TownHall $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        $locale = app(Locales::class)->current();

        return $this->model->with('settlements')->select(
            'town_halls.*',
            'town_hall_translations.name as town_hall_name',
            'municipality_translations.name as municipality_name',
        )->leftJoin('town_hall_translations', function ($join) use ($locale) {
            $join->on('town_halls.id', '=', 'town_hall_translations.town_hall_id')
                ->where('town_hall_translations.locale', $locale);
        })->leftJoin('municipality_translations', function ($join) use ($locale) {
            $join->on('town_halls.municipality_id', '=', 'municipality_translations.municipality_id')
                ->where('municipality_translations.locale', $locale);
        });
    }

    /**
     * Get all town halls by a specific municipality ID.
     */
    public function getAllByMunicipalityId(int $id): Collection
    {
        return $this->model->where('municipality_id', $id)->get();
    }
}
