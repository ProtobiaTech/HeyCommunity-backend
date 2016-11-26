<?php

use Illuminate\Database\Seeder;

class TimelineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::get()->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            $userId = $faker->randomElement($users);
            $user = $faker->randomElement($users);
            $userId = $user['id'];
            $tenantId = $user['tenant_id'];

            $data[] = [
                'tenant_id'     =>      $tenantId,
                'user_id'       =>      $userId,
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 5))),
                'imgs'          =>      null,

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Timeline::insert($data);
    }
}
