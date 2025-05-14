<?php

namespace Database\Factories;

use App\Models\MenuCategory;
use Illuminate\Database\Eloquent\Factories\Factory;


class MenuCategoryFactory extends Factory
{
 
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'is_active' => $this->faker->boolean(85),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (MenuCategory $category) {
            $count = rand(2, 4);
            for ($i = 0; $i < $count; $i++) {
                $category->addMediaFromUrl('https://www.elmenus.com/public/img/default-cover.png')
                    ->toMediaCollection('category_images');
            }
        });
    }
}
