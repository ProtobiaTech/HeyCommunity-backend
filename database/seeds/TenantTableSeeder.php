<?php

use Illuminate\Database\Seeder;

class TenantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        \App\Tenant::create([
            'site_name'     =>  'Dev Community',
            'domain'        =>  'localhost:6888',
            'email'         =>  'admin@localhost.local',
            'phone'         =>  $faker->phoneNumber(),
            'password'      =>  bcrypt('hey community'),
        ]);

        foreach (range(1, 68) as $index) {
            \App\Tenant::create([
                'site_name'     =>  $faker->name(),
                'domain'        =>  $faker->domainName(),
                'email'         =>  $faker->email(),
                'phone'         =>  $faker->phoneNumber(),
                'password'      =>  bcrypt('hey community'),
            ]);
        }
    }
}
