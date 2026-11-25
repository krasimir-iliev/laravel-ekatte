<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Municipality;
use App\Models\Region;
use App\Models\Settlement;
use App\Models\SettlementKind;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EkatteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates and verifies the complete EKATTE hierarchy.
     */
    public function test_it_creates_the_full_ekatte_hierarchy(): void
    {
        // Locales
        $locales = app(Locales::class)->all();

        // Locales are configured
        $this->assertNotEmpty($locales);

        // Region
        $region = Region::factory()->create();

        // District
        $district = District::factory()->for($region)->create();

        // Municipality
        $municipality = Municipality::factory()->for($district)->create();

        // TownHall
        $townHall = TownHall::factory()->for($municipality)->create();

        // SettlementKind
        $settlementKind = SettlementKind::factory()->create();

        // Settlement
        $settlement = Settlement::factory()->for($townHall)->for($settlementKind)->create();

        // Region exists in database
        $this->assertDatabaseHas('regions', [
            'id' => $region->id,
            'code' => $region->code,
        ]);

        // District exists in database
        $this->assertDatabaseHas('districts', [
            'id' => $district->id,
            'region_id' => $region->id,
            'code' => $district->code,
        ]);

        // Municipality exists in database
        $this->assertDatabaseHas('municipalities', [
            'id' => $municipality->id,
            'district_id' => $district->id,
            'code' => $municipality->code,
        ]);

        // TownHall exists in database
        $this->assertDatabaseHas('town_halls', [
            'id' => $townHall->id,
            'municipality_id' => $municipality->id,
            'code' => $townHall->code,
        ]);

        // SettlementKind exists in database
        $this->assertDatabaseHas('settlement_kinds', [
            'id' => $settlementKind->id,
            'code' => $settlementKind->code,
            'name' => $settlementKind->name,
            'short_name' => $settlementKind->short_name,
        ]);

        // Settlement exists in database
        $this->assertDatabaseHas('settlements', [
            'id' => $settlement->id,
            'settlement_kind_id' => $settlementKind->id,
            'town_hall_id' => $townHall->id,
            'ekatte' => $settlement->ekatte,
        ]);

        // Relations
        $this->assertSame($region->id, $district->region->id);
        $this->assertSame($district->id, $municipality->district->id);
        $this->assertSame($municipality->id, $townHall->municipality->id);
        $this->assertSame($townHall->id, $settlement->townHall->id);
        $this->assertSame($settlementKind->id, $settlement->settlementKind->id);

        // Translations exist in database
        $translations = [
            [$region, 'region_translations', 'region_id'],
            [$district, 'district_translations', 'district_id'],
            [$municipality, 'municipality_translations', 'municipality_id'],
            [$townHall, 'town_hall_translations', 'town_hall_id'],
            [$settlement, 'settlement_translations', 'settlement_id'],
        ];

        foreach ($translations as [$model, $table, $foreignKey]) {
            foreach ($locales as $locale) {
                $this->assertDatabaseHas($table, [
                    $foreignKey => $model->id,
                    'locale' => $locale,
                    'name' => $model->translate($locale)->name,
                ]);
            }
        }
    }
}
