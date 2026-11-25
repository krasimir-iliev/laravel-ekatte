<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Municipality;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MunicipalityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a municipality with translations.
     */
    public function test_it_creates_a_municipality_with_translations(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // District
        $district = District::factory()->create();

        // Municipality
        $municipality = Municipality::factory()->for($district)->create();

        // Municipality exists in database
        $this->assertDatabaseHas('municipalities', [
            'id' => $municipality->id,
            'district_id' => $district->id,
            'code' => $municipality->code,
        ]);

        // Translations exist in database
        foreach ($locales as $locale) {
            $this->assertDatabaseHas('municipality_translations', [
                'municipality_id' => $municipality->id,
                'locale' => $locale,
                'name' => $municipality->translate($locale)->name,
            ]);
        }
    }
}
