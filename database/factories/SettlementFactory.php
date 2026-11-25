<?php

namespace Database\Factories;

use App\Models\Settlement;
use App\Models\SettlementKind;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Settlement>
 */
class SettlementFactory extends Factory
{
    /**
     * @var array<int, string>
     */
    private array $locales;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $data = [
            'settlement_kind_id' => SettlementKind::factory(),
            'town_hall_id' => TownHall::factory(),
            'ekatte' => fake()->unique()->bothify('S####'),
        ];

        $this->locales = $this->locales ?? app(Locales::class)->all();

        foreach ($this->locales as $locale) {
            $data[$locale] = [
                'name' => fake()->lexify(
                    str_repeat('?', fake()->numberBetween(10, 64))
                ),
            ];
        }

        return $data;
    }
}
