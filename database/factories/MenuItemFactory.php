<?php

namespace Database\Factories;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuItemFactory extends Factory
{
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month', '+1 week');
        $end = $this->faker->dateTimeBetween($start, '+2 weeks');
        $daily_availability = $this->faker->numberBetween(10, 100);
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 5, 100),
            'daily_availability' => $daily_availability,
            'current_availability' => $daily_availability,
            'discount_amount' => $this->faker->randomFloat(2, 0, 30),
            'discount_type' => $this->faker->randomElement(['percentage', 'fixed']),
            'discount_start_at' => $start,
            'discount_end_at' => $end,
            'is_active' => $this->faker->boolean(),
            'category_id' => \App\Models\MenuCategory::factory(),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (MenuItem $menu_item) {
            $count = rand(2, 4);
            for ($i = 0; $i < $count; $i++) {
                $menu_item->addMediaFromUrl('https://www.elmenus.com/public/img/default-cover.png')
                    ->toMediaCollection('menu_images');
            }
        });
    }
}
