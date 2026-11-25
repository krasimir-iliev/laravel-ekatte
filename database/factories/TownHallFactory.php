<?php

namespace Database\Factories;

use App\Models\Municipality;
use App\Models\TownHall;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TownHall>
 */
class TownHallFactory extends Factory
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
            'municipality_id' => Municipality::factory(),
            'code' => fake()->unique()->bothify('TH######'),
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
