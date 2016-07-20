<?php

use Illuminate\Database\Seeder;

class TopicTableSeeder extends Seeder
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
        foreach (range(1, 268) as $index) {
            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 5))),
                'avatar'        =>      $faker->imageUrl(),
                'is_top'        =>      random_int(0, 1),
                'is_excellent'  =>      random_int(0, 1),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Topic::insert($data);
    }
}
