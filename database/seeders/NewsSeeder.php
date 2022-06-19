<?php

namespace Database\Seeders;

use App\Models\News;
use Faker\Factory;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fake = Factory::create();

        foreach (range(1, 10) as $index) {
            News::create([
                'title' => $fake->sentence,
                'description' => $fake->paragraph,
                'image' => $fake->imageUrl(),
                'category_id' => $fake->numberBetween(1, 10),
                'date' => $fake->dateTimeBetween('-1 years', 'now'),
            ]);
        }
    }
}
