<?php

namespace App\Imports\Panel;

use App\Models\District;
use App\Models\Municipality;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MunicipalitiesImport implements ToModel, WithHeadingRow
{
    /**
     * @var Collection<string, int>
     */
    private Collection $districtCodes;

    /**
     * @var array<int, string>
     */
    private array $locales;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->districtCodes = District::pluck('id', 'code');

        $this->locales = app(Locales::class)->all();
    }

    /**
     * Map an Excel row to a Municipality model.
     */
    public function model(array $row): ?Model
    {
        $code = trim($row['code'] ?? '');

        if ($code === '') {
            return null;
        }

        $districtId = $this->districtCodes[substr($code, 0, -2)] ?? null;

        if ($districtId === null) {
            return null;
        }

        $values = [
            'district_id' => $districtId,
        ];

        foreach ($this->locales as $locale) {
            $name = trim($row['name_' . $locale] ?? '');

            if ($name !== '') {
                $values[$locale]['name'] = $name;
            }
        }

        return Municipality::updateOrCreate([
            'code' => $code,
        ], $values);
    }
}
