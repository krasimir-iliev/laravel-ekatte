<?php

namespace Tests\Feature;

use App\Models\Municipality;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TownHallTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a town hall with translations.
     */
    public function test_it_creates_a_town_hall_with_translations(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // Municipality
        $municipality = Municipality::factory()->create();

        // TownHall
        $townHall = TownHall::factory()->for($municipality)->create();

        // TownHall exists in database
        $this->assertDatabaseHas('town_halls', [
            'id' => $townHall->id,
            'municipality_id' => $municipality->id,
            'code' => $townHall->code,
        ]);

        // Translations exist in database
        foreach ($locales as $locale) {
            $this->assertDatabaseHas('town_hall_translations', [
                'town_hall_id' => $townHall->id,
                'locale' => $locale,
                'name' => $townHall->translate($locale)->name,
            ]);
        }
    }
}
