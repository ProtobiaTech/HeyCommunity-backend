<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
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
        foreach (range(1, 268) as $index) {
            \App\Activity::create([
                'user_id'       =>      $faker->randomElement($users),
                'tenant_id'     =>      $faker->randomElement($tenants),
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('<br>', $faker->paragraphs(random_int(2, 10))),
                'avatar'        =>      $faker->imageUrl(200, 200),

                'start_date'    =>      $faker->dateTimeBetween('- 10 days', 'now'),
                'end_date'      =>      $faker->dateTimeBetween('now', '+ 30 days'),
            ]);
        }
    }
}
