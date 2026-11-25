<?php

namespace App\Exports\Panel;

use App\Models\Region;
use Astrotomic\Translatable\Locales;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RegionsExport implements FromView, ShouldAutoSize
{
    /**
     * Get the export view.
     */
    public function view(): View
    {
        return view('panel.regions.export', [
            'locales' => app(Locales::class)->all(),
            'regions' => Region::with('translations')->get(),
        ]);
    }
}
