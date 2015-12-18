<?php

use Illuminate\Database\Seeder;

class TimelineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            \App\Timeline::create([
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('<br>', $faker->paragraphs(random_int(1,5))),
                'attachment'    =>      $faker->imageUrl(),
            ]);
        }
    }
}
