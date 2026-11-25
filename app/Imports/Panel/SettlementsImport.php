<?php

namespace App\Imports\Panel;

use App\Models\Settlement;
use App\Models\SettlementKind;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SettlementsImport implements ToModel, WithHeadingRow
{
    /**
     * @var Collection<string, int>
     */
    private Collection $settlementKindCodes;

    /**
     * @var Collection<string, int>
     */
    private Collection $townHallCodes;

    /**
     * @var array<int, string>
     */
    private array $locales;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->settlementKindCodes = SettlementKind::pluck('id', 'code');

        $this->townHallCodes = TownHall::pluck('id', 'code');

        $this->locales = app(Locales::class)->all();
    }

    /**
     * Map an Excel row to a Settlement model.
     */
    public function model(array $row): ?Model
    {
        $ekatte = trim($row['ekatte'] ?? '');
        $townHallCode = trim($row['town_hall_code'] ?? '');
        $kind = trim($row['kind'] ?? '');

        if (in_array('', [$ekatte, $townHallCode, $kind], true)) {
            return null;
        }

        $settlementKindId = $this->settlementKindCodes[$kind] ?? null;
        $townHallId = $this->townHallCodes[$townHallCode] ?? null;

        if ($settlementKindId === null || $townHallId === null) {
            return null;
        }

        $values = [
            'settlement_kind_id' => $settlementKindId,
            'town_hall_id' => $townHallId,
        ];

        foreach ($this->locales as $locale) {
            $name = trim($row['name_' . $locale] ?? '');

            if ($name !== '') {
                $values[$locale]['name'] = $name;
            }
        }

        return Settlement::updateOrCreate([
            'ekatte' => $ekatte,
        ], $values);
    }
}
