<?php

namespace Database\Factories;

use App\Models\SettlementKind;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SettlementKind>
 */
class SettlementKindFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->lexify(
            str_repeat('?', fake()->numberBetween(10, 16))
        );

        return [
            'code' => fake()->unique()->numberBetween(1, 127),
            'name' => $name,
            'short_name' => substr($name, 0, fake()->numberBetween(2, 4)) . '.',
        ];
    }
}
