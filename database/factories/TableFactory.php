<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    public function definition(): array
    {
        return [
            'number' => 'TABLE-' . $this->faker->unique()->numerify('###'),
            'capacity' => $this->faker->numberBetween(2, 10),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
