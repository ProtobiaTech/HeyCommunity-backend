<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // administrator
        \App\User::create([
            'nickname'      =>  'admin',
            'email'         =>  'admin@hey-community.online',
            'password'      =>  bcrypt('hey-community'),
        ]);

        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            \App\User::create([
                'nickname'      =>  $faker->name(),
                'email'         =>  $faker->email(),
                'password'      =>  bcrypt('hey community'),
            ]);
        }
    }
}
