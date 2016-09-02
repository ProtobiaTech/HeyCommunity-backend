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
        $users = \App\User::lists('id')->toArray();
        $timelineImgs = \App\TimelineImg::lists('id')->toArray();
        $tenants = \App\Tenant::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 668) as $index) {
            $imgs = null;
            if (random_int(1, 4) > 1) {
                $ram = random_int(1, 7);
                if ($ram === 7) {
                    $count = 3;
                } else if ($ram > 4) {
                    $count = 2;
                } else {
                    $count = 1;
                }
                $imgs = $faker->randomElements($timelineImgs, $count);
                $imgs = json_encode($imgs);
            }

            $data[] = [
                'tenant_id'     =>  $faker->randomElement($tenants),
                'user_id'       =>      $faker->randomElement($users),
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 5))),
                'imgs'          =>      $imgs,

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Timeline::insert($data);
    }
}
