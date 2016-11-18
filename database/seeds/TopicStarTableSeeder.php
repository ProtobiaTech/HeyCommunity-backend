<?php

use Illuminate\Database\Seeder;

class TopicStarTableSeeder extends Seeder
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
        $users = \App\User::lists('id')->toArray();
        $topics = \App\Topic::lists('id')->toArray();

        $faker = Faker\Factory::create();

        $data = [];
        $topicStarNum = [];
        foreach (range(1, 328) as $index) {
            do {
                $userId = $faker->randomElement($users);
                $topicId = $faker->randomElement($topics);
            } while ($this->sameData($userId, $topicId, $data));

            if (isset($topicStarNum[$topicId])) {
                $topicStarNum[$topicId]++;
            } else {
                $topicStarNum[$topicId] = 1;
            }

            $data[] = [
                'user_id'       =>      $userId,
                'topic_id'      =>      $topicId,

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\TopicStar::insert($data);

        foreach ($topicStarNum as $key => $value) {
            \App\Topic::where('id', $key)->update(['star_num' => $value]);
        }
    }
}
