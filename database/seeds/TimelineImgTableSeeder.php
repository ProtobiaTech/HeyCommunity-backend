<?php

use Illuminate\Database\Seeder;

class TimelineImgTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::lists('id')->toArray();
        $tenants = \App\Tenant::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 66) as $index) {
            $data[] = [
                'tenant_id'     =>      $faker->randomElement($tenants),
                'user_id'       =>      $faker->randomElement($users),
                'uri'           =>      $faker->imageUrl(),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\TimelineImg::insert($data);
    }
}
