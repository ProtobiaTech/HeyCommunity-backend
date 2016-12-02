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
        \App\User::create([
            'tenant_id'     =>      1,
            'nickname'      =>      'Rod',
            'avatar'        =>      '/assets/images/userAvatar-default.png',
            'email'         =>      'supgeek.rod@gmail.com',
            'phone'         =>      '17090402884',
            'password'      =>      bcrypt('123123'),
        ]);
        \App\User::create([
            'tenant_id'     =>      1,
            'nickname'      =>      'Test User',
            'avatar'        =>      '/assets/images/userAvatar-default.png',
            'email'         =>      'test@hey-community.cn',
            'phone'         =>      '12312341234',
            'password'      =>      Hash::make('123123'),
        ]);

        $tenants = \App\Tenant::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            $data[] = [
                'tenant_id'     =>  $faker->randomElement($tenants),
                'nickname'      =>  $faker->name(),
                'avatar'        =>  $faker->imageUrl(300, 300, 'people'),
                'email'         =>  $faker->email(),
                'phone'         =>  $faker->phoneNumber(),
                'password'      =>  bcrypt('hey community'),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\User::insert($data);
    }
}
