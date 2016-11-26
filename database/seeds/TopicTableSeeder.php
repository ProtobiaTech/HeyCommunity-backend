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
        $users = \App\User::get()->toArray();
        $topicNodes = \App\TopicNode::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 128) as $index) {
            $user = $faker->randomElement($users);
            $userId = $user['id'];
            $tenantId = $user['tenant_id'];

            $data[] = [
                'tenant_id'     =>      $tenantId,
                'user_id'       =>      $userId,
                'topic_node_id' =>      $faker->randomElement($topicNodes),
                'title'         =>      $faker->sentence(6),
                'content'       =>      implode('', $faker->paragraphs(random_int(4, 9))),

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\Topic::insert($data);
    }
}
