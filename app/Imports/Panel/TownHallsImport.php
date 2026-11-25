<?php

namespace App\Imports\Panel;

use App\Models\Municipality;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TownHallsImport implements ToModel, WithHeadingRow
{
    /**
     * Map of municipality codes to IDs.
     *
     * @var Collection<string, int>
     */
    private Collection $municipalityCodes;

    /**
     * @var array<int, string>
     */
    private array $locales;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->municipalityCodes = Municipality::pluck('id', 'code');

        $this->locales = app(Locales::class)->all();
    }

    /**
     * Map an Excel row to a TownHall model.
     */
    public function model(array $row): ?Model
    {
        $code = trim($row['code'] ?? '');

        if ($code === '') {
            return null;
        }

        $municipalityId = $this->municipalityCodes[substr($code, 0, -3)] ?? null;

        if ($municipalityId === null) {
            return null;
        }

        $values = [
            'municipality_id' => $municipalityId,
        ];

        foreach ($this->locales as $locale) {
            $name = trim($row['name_' . $locale] ?? '');

            if ($name !== '') {
                $values[$locale]['name'] = $name;
            }
        }

        return TownHall::updateOrCreate([
            'code' => $code,
        ], $values);
    }
}
