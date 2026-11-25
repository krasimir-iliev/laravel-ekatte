<?php

namespace App\Imports\Panel;

use App\Models\Region;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegionsImport implements ToModel, WithHeadingRow
{
    /**
     * @var array<int, string>
     */
    private array $locales;

    /**
     * Create a new instance.
     */
    public function __construct()
    {
        $this->locales = app(Locales::class)->all();
    }

    /**
     * Map an Excel row to a Region model.
     */
    public function model(array $row): ?Model
    {
        $code = trim($row['code'] ?? '');

        if ($code === '') {
            return null;
        }

        $values = [];

        foreach ($this->locales as $locale) {
            $name = trim($row['name_' . $locale] ?? '');

            if ($name !== '') {
                $values[$locale]['name'] = $name;
            }
        }

        return Region::updateOrCreate([
            'code' => $code,
        ], $values);
    }
}
