<?php

use Illuminate\Database\Seeder;

class NoticeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $users = \App\User::lists('id')->toArray();
        $tenants = \App\Tenant::lists('id')->toArray();
        $noticeTypes = \App\NoticeType::lists('id')->toArray();
        $timelines = \App\Timeline::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 868) as $index) {
            $timelineId = $faker->randomElement($timelines);

            \App\Notice::create([
                'user_id'       =>      $faker->randomElement($users),
                'tenant_id'     =>      with(\App\Timeline::find($timelineId))->tenant_id,
                'type_id'       =>      $faker->randomElement($noticeTypes),
                'entity_id'     =>      $faker->randomElement($timelines),
            ]);
        }
    }
}
