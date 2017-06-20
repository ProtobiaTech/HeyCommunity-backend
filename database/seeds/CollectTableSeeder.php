<?php

use Illuminate\Database\Seeder;

class CollectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::lists('id')->toArray();
        $types = array_keys(\App\Collect::$types);

        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'type_id'       =>      $faker->randomElement($types),
                'name'          =>      $faker->word(),
                'description'   =>      $faker->paragraph(),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Collect::insert($data);
    }
}
