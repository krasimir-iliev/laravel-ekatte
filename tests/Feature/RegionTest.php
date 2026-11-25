<?php

namespace Tests\Feature;

use App\Models\Region;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a region with translations.
     */
    public function test_it_creates_a_region_with_translations(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // Region
        $region = Region::factory()->create();

        // Region exists in database
        $this->assertDatabaseHas('regions', [
            'id' => $region->id,
            'code' => $region->code,
        ]);

        // Translations exist in database
        foreach ($locales as $locale) {
            $this->assertDatabaseHas('region_translations', [
                'region_id' => $region->id,
                'locale' => $locale,
                'name' => $region->translate($locale)->name,
            ]);
        }
    }
}
