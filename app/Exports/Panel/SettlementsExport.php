<?php

namespace App\Exports\Panel;

use App\Models\Settlement;
use Astrotomic\Translatable\Locales;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class SettlementsExport extends DefaultValueBinder implements FromView, ShouldAutoSize, WithCustomValueBinder
{
    /**
     * Bind value to a cell.
     */
    public function bindValue(Cell $cell, mixed $value): bool
    {
        if ($cell->getColumn() === 'A') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }

    /**
     * Get the export view.
     */
    public function view(): View
    {
        return view('panel.settlements.export', [
            'locales' => app(Locales::class)->all(),
            'settlements' => Settlement::with([
                'settlementKind',
                'translations',
                'townHall.translations',
                'townHall.municipality.translations',
                'townHall.municipality.district.translations',
            ])->get()
        ]);
    }
}
