<?php

namespace Tests\Feature;

use App\Models\Settlement;
use App\Models\SettlementKind;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettlementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a settlement with translations.
     */
    public function test_it_creates_a_settlement_with_translations(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // TownHall
        $townHall = TownHall::factory()->create();

        // SettlementKind
        $settlementKind = SettlementKind::factory()->create();

        // Settlement
        $settlement = Settlement::factory()->for($townHall)->for($settlementKind)->create();

        // Settlement exists in database
        $this->assertDatabaseHas('settlements', [
            'id' => $settlement->id,
            'settlement_kind_id' => $settlementKind->id,
            'town_hall_id' => $townHall->id,
            'ekatte' => $settlement->ekatte,
        ]);

        // Translations exist in database
        foreach ($locales as $locale) {
            $this->assertDatabaseHas('settlement_translations', [
                'settlement_id' => $settlement->id,
                'locale' => $locale,
                'name' => $settlement->translate($locale)->name,
            ]);
        }
    }
}
