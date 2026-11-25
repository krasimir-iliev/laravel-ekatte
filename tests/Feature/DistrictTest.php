<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Region;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DistrictTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a district linked to a region with translations.
     */
    public function test_it_creates_a_district_with_translations(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // Region
        $region = Region::factory()->create();

        // District
        $district = District::factory()->for($region)->create();

        // District exists in database
        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'region_id' => $region->id,
            'code' => $district->code,
        ]);

        // Translations exist in database
        foreach ($locales as $locale) {
            $this->assertDatabaseHas('district_translations', [
                'district_id' => $district->id,
                'locale' => $locale,
                'name' => $district->translate($locale)->name,
            ]);
        }
    }
}
