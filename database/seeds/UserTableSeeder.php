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
        $faker = Faker\Factory::create();

        \App\User::create([
            'nickname'      =>  'Rod',
            'avatar'        =>  $faker->imageUrl(),
            'email'         =>  'supgeek.rod@gmail.com',
            'phone'         =>  '17090402884',
            'password'      =>  bcrypt('123123'),
        ]);
        \App\User::create([
            'nickname'      =>      'Robot',
            'avatar'        =>  $faker->imageUrl(),
            'email'         =>      'robot@hey-community.online',
            'phone'         =>      '12312312312',
            'password'      =>      Hash::make('hey community'),
        ]);

        foreach (range(1, 68) as $index) {
            \App\User::create([
                'nickname'      =>  $faker->name(),
                'avatar'        =>  $faker->imageUrl(),
                'email'         =>  $faker->email(),
                'phone'         =>  $faker->phoneNumber(),
                'password'      =>  bcrypt('hey community'),
            ]);
        }
    }
}
