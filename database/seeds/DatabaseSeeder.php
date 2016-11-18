<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);

        $this->call(TimelineTableSeeder::class);
        $this->call(TimelineImgTableSeeder::class);
        $this->call(TimelineCommentTableSeeder::class);

        $this->call(TopicNodeTableSeeder::class);
        $this->call(TopicTableSeeder::class);
        $this->call(TopicCommentTableSeeder::class);
        $this->call(TopicStarTableSeeder::class);
        $this->call(TopicThumbTableSeeder::class);

        Model::reguard();
    }
}
