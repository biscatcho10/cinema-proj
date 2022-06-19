<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = \Faker\Factory::create();

        foreach (range(1, 10) as $index) {
            Category::create([
                'name' => $fake->word,
                'description' => $fake->paragraph,
            ]);
        }
    }
}
