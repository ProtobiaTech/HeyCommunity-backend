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
        $users = \App\User::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 5))),
                'imgs'          =>      null,

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Timeline::insert($data);
    }
}
