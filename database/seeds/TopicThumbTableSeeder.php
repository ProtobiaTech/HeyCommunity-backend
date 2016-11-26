<?php

use Illuminate\Database\Seeder;

class TopicThumbTableSeeder extends Seeder
{
    /**
     *
     */
    public function sameData($userId, $topicId, $data)
    {
        foreach ($data as $v) {
            return $v['user_id'] === $userId && $v['topic_id'] === $topicId ? true : false;
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker\Factory::create();

        $users = \App\User::lists('id')->toArray();
        $topics = \App\Topic::lists('id')->toArray();

        $data = [];
        foreach (range(1, 388) as $index) {
            do {
                $userId = $faker->randomElement($users);
                $topicId = $faker->randomElement($topics);
            } while ($this->sameData($userId, $topicId, $data));

            $value = $faker->randomElement([1, 2]);

            if ($value === 1) {
                if (isset($topicThumbUpNum[$topicId])) {
                    $topicThumbUpNum[$topicId]++;
                } else {
                    $topicThumbUpNum[$topicId] = 1;
                }
            } else {
                if (isset($topicThumbDownNum[$topicId])) {
                    $topicThumbDownNum[$topicId]++;
                } else {
                    $topicThumbDownNum[$topicId] = 1;
                }
            }

            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'topic_id'      =>      $topicId,
                'value'         =>      $value,

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\TopicThumb::insert($data);


        foreach ($topicThumbUpNum as $key => $value) {
            \App\Topic::where('id', $key)->update(['thumb_up_num' => $value]);
        }

        foreach ($topicThumbDownNum as $key => $value) {
            \App\Topic::where('id', $key)->update(['thumb_down_num' => $value]);
        }
    }
}
