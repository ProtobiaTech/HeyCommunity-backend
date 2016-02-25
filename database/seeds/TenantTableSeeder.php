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
