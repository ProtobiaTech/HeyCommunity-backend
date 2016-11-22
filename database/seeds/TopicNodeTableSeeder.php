<?php

use Illuminate\Database\Seeder;

class TopicNodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $data = [
            ['id' => 2, 'name' => 'Node 2'],
            ['id' => 3, 'name' => 'Node 3'],
            ['id' => 4, 'name' => 'Node 4'],
        ];
        \App\TopicNode::insert($data);

        $data = [];
        foreach (range(1, 6) as $index) {
            $data[] = [
                'parent_id'     =>      $faker->randomElement([1,2,3,4]),
                'name'          =>      $faker->word(),
            ];
        }
        \App\TopicNode::insert($data);
    }
}
