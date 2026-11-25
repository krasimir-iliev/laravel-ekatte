<?php

namespace App\Imports\Panel;

use App\Models\District;
use App\Models\Region;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DistrictsImport implements ToModel, WithHeadingRow
{
    /**
     * @var Collection<string, int>
     */
    private Collection $regionCodes;

    /**
     * @var array<int, string>
     */
    private array $locales;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->regionCodes = Region::pluck('id', 'code');

        $this->locales = app(Locales::class)->all();
    }

    /**
     * Map an Excel row to a District model.
     */
    public function model(array $row): ?Model
    {
        $code = trim($row['code'] ?? '');
        $regionCode = trim($row['region_code'] ?? '');

        if ($code === '' || $regionCode === '') {
            return null;
        }

        $regionId = $this->regionCodes[$regionCode] ?? null;

        if ($regionId === null) {
            return null;
        }

        $values = [
            'region_id' => $regionId,
        ];

        foreach ($this->locales as $locale) {
            $name = trim($row['name_' . $locale] ?? '');

            if ($name !== '') {
                $values[$locale]['name'] = $name;
            }
        }

        return District::updateOrCreate([
            'code' => $code,
        ], $values);
    }
}
