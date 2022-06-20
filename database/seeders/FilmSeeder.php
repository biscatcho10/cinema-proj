<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
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
            \App\Models\Film::create([
                'title' => $fake->sentence,
                'image' => $fake->imageUrl,
                'show_date' => $fake->date,
                'category_id' => $fake->numberBetween(1, 10),
            ]);
        }
    }
}
