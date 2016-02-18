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
            'site_name'     =>  'Demo Community',
            'domain'        =>  'demo.hey-community.cn',
            'sub_domain'    =>  'demo.hey-community.online',
            'email'         =>  'supgeek.rod@gmail.com',
            'phone'         =>  '12312341234',
            'password'      =>  bcrypt('hey community'),
        ]);

        \App\Tenant::create([
            'site_name'     =>  'Demo Community',
            'domain'        =>  'demo.hey-community.local',
            'sub_domain'    =>  'superods-macbook.local',
            'email'         =>  'supgeek.rod@gmail.local',
            'phone'         =>  '12312341235',
            'password'      =>  bcrypt('hey community'),
        ]);

        foreach (range(1, 3) as $index) {
            $domain = $faker->unique()->domainName();
            \App\Tenant::create([
                'site_name'     =>  $faker->name(),
                'domain'        =>  $domain,
                'sub_domain'    =>  'sub.' . $domain,
                'email'         =>  $faker->email(),
                'phone'         =>  $faker->phoneNumber(),
                'password'      =>  bcrypt('hey community'),
            ]);
        }
    }
}
