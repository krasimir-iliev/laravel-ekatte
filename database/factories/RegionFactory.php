<?php

namespace Database\Factories;

use App\Models\Region;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
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
            'code' => fake()->unique()->bothify('R###'),
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
