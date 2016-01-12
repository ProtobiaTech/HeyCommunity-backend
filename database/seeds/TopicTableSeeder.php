<?php

use Illuminate\Database\Seeder;

class TopicTableSeeder extends Seeder
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
            \App\Topic::create([
                'user_id'       =>      $faker->randomElement($users),
                'tenant_id'     =>      $faker->randomElement($tenants),
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 5))),
                'avatar'        =>      $faker->imageUrl(),
            ]);
        }
    }
}
