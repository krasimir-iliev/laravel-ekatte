<?php

namespace Tests\Feature;

use App\Models\SettlementKind;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettlementKindTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Creates a settlement kind.
     */
    public function test_it_creates_a_settlement_kind(): void
    {
        // SettlementKind
        $settlementKind = SettlementKind::factory()->create();

        // SettlementKind exists in database
        $this->assertDatabaseHas('settlement_kinds', [
            'id' => $settlementKind->id,
            'code' => $settlementKind->code,
            'name' => $settlementKind->name,
            'short_name' => $settlementKind->short_name,
        ]);
    }
}
