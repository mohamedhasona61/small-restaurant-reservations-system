<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TableSeeder::class);
        $this->call(MenuCategorySeeder::class);
        $this->call(MenuItemSeeder::class);
    }
}
