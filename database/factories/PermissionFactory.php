<?php

namespace Database\Factories;

use App\Models\Permission;
use Astrotomic\Translatable\Locales;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permission>
 */
class PermissionFactory extends Factory
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
            'name' => fake()->unique()->lexify(
                str_repeat('?', fake()->numberBetween(10, 255))
            ),
        ];

        $this->locales = $this->locales ?? app(Locales::class)->all();

        foreach ($this->locales as $locale) {
            $data[$locale] = [
                'display_name' => fake()->lexify(
                    str_repeat('?', fake()->numberBetween(10, 255))
                ),
            ];
        }

        return $data;
    }
}
