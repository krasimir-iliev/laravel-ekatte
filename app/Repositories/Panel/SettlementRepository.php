<?php

namespace App\Repositories\Panel;

use App\Models\Settlement;
use App\Repositories\Repository;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Builder;

class SettlementRepository extends Repository
{
    /**
     * Create a new repository instance.
     */
    public function __construct(protected Settlement $model) {}

    /**
     * Get the query source of dataTable.
     */
    public function query(array $data): Builder
    {
        $locale = app(Locales::class)->current();

        $settlements = $this->model->with('settlementKind')->select(
            'settlements.*',
            'settlement_translations.name as settlement_name',
            'town_hall_translations.name as town_hall_name',
            'municipality_translations.name as municipality_name',
            'district_translations.name as district_name',
        )->join('town_halls', function ($join) {
            $join->on('settlements.town_hall_id', '=', 'town_halls.id');
        })->join('municipalities', function ($join) {
            $join->on('town_halls.municipality_id', '=', 'municipalities.id');
        })->join('districts', function ($join) {
            $join->on('municipalities.district_id', '=', 'districts.id');
        })->leftJoin('settlement_translations', function ($join) use ($locale) {
            $join->on('settlements.id', '=', 'settlement_translations.settlement_id')
                ->where('settlement_translations.locale', $locale);
        })->leftJoin('town_hall_translations', function ($join) use ($locale) {
            $join->on('settlements.town_hall_id', '=', 'town_hall_translations.town_hall_id')
                ->where('town_hall_translations.locale', $locale);
        })->leftJoin('municipality_translations', function ($join) use ($locale) {
            $join->on('municipalities.id', '=', 'municipality_translations.municipality_id')
                ->where('municipality_translations.locale', $locale);
        })->leftJoin('district_translations', function ($join) use ($locale) {
            $join->on('districts.id', '=', 'district_translations.district_id')
                ->where('district_translations.locale', $locale);
        });

        if (!empty($data['town_hall_id'])) {
            $settlements->where('settlements.town_hall_id', $data['town_hall_id']);
        } elseif (!empty($data['municipality_id'])) {
            $settlements->where('town_halls.municipality_id', $data['municipality_id']);
        } elseif (!empty($data['district_id'])) {
            $settlements->where('municipalities.district_id', $data['district_id']);
        }

        return $settlements;
    }

    /**
     * Show a specific settlement by ID.
     */
    public function show(int $id): Settlement
    {
        return $this->model->with([
            'settlementKind',
            'townHall.municipality.district',
        ])->findOrFail($id);
    }
}
