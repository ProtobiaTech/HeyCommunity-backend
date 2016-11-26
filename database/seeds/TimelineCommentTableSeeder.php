<?php

use Illuminate\Database\Seeder;

class TimelineCommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = \App\User::lists('id')->toArray();
        $timelines = \App\Timeline::get()->toArray();

        $faker = Faker\Factory::create();

        $tlComment = [];
        foreach (range(1, 868) as $index) {
            $timeline   = $faker->randomElement($timelines);
            $timelineId = $timeline['id'];
            $tenantId = $timeline['tenant_id'];
            $userId = $timeline['user_id'];

            if (isset($tlComment[$timelineId])) {
                $tlComment[$timelineId]++;
            } else {
                $tlComment[$timelineId] = 1;
            }

            $data[] = [
                'tenant_id'     =>      $tenantId,
                'user_id'       =>      $userId,
                'timeline_id'   =>      $timelineId,
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 2))),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\TimelineComment::insert($data);

        foreach ($tlComment as $key => $value) {
            \App\Timeline::where('id', $key)->update(['comment_num' => $value]);
        }
    }
}
