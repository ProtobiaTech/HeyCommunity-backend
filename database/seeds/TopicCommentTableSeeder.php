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
        $tenants = \App\Tenant::lists('id')->toArray();
        $topics = \App\Topic::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 868) as $index) {
            $topicId = $faker->randomElement($tenants);

            \App\TopicComment::create([
                'user_id'       =>      $faker->randomElement($users),
                'tenant_id'     =>      $topicId,
                'topic_id'      =>      with(\App\Topic::find($topicId))->tenant_id,
                'topic_id'      =>      $faker->randomElement($topics),
                'content'       =>      implode('', $faker->paragraphs(random_int(1, 2))),
            ]);
        }
    }
}
