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
            'nickname'      =>      'Rod',
            'avatar'        =>      '/assets/images/userAvatar-default.png',
            'email'         =>      'supgeek.rod@gmail.com',
            'phone'         =>      '17090402884',
            'password'      =>      bcrypt('123123'),
        ]);
        \App\User::create([
            'nickname'      =>      'Test User',
            'avatar'        =>      '/assets/images/userAvatar-default.png',
            'email'         =>      'test@hey-community.cn',
            'phone'         =>      '12312345678',
            'password'      =>      Hash::make('123123'),
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
