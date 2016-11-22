<?php

use Illuminate\Database\Seeder;

class TopicCommentTableSeeder extends Seeder
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
        $topics = \App\Topic::lists('id')->toArray();

        $faker = Faker\Factory::create();

        $topicCommentsNum = [];
        $data = [];
        foreach (range(1, 168) as $index) {
            $topicId = $faker->randomElement($topics);
            if (isset($topicCommentsNum[$topicId])) {
                $topicCommentsNum[$topicId]++;
            } else {
                $topicCommentsNum[$topicId] = 1;
            }

            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'topic_id'      =>      $topicId,
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 3))),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\TopicComment::insert($data);


        //
        $topicComments = \App\TopicComment::get()->toArray();
        $data = [];
        foreach (range(1, 368) as $index) {
            $topicComment = $faker->randomElement($topicComments);
            $topicId = $topicComment['topic_id'];
            if (isset($topicCommentsNum[$topicId])) {
                $topicCommentsNum[$topicId]++;
            } else {
                $topicCommentsNum[$topicId] = 1;
            }

            $data[] = [
                'user_id'       =>      $faker->randomElement($users),
                'topic_id'      =>      $topicId,
                'parent_id'     =>      $topicComment['id'],
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 3))),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\TopicComment::insert($data);

        foreach ($topicCommentsNum as $key => $value) {
            \App\Topic::where('id', $key)->update(['comment_num' => $value]);
        }
    }
}
