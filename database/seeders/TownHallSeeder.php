<?php

namespace Database\Seeders;

use App\Imports\Panel\TownHallsImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class TownHallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Excel::import(new TownHallsImport, base_path('database/data/town_halls.xlsx'));
    }
}
