<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 668) as $index) {
            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('', $faker->paragraphs(random_int(2, 10))),
                'avatar'        =>      $faker->imageUrl(200, 200),

                'start_date'    =>      $faker->dateTimeBetween('- 10 days', 'now'),
                'end_date'      =>      $faker->dateTimeBetween('now', '+ 30 days'),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Activity::insert($data);
    }
}
