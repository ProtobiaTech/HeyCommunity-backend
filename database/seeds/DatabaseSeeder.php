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
        $this->call(TenantTableSeeder::class);
        $this->call(TimelineTableSeeder::class);
        $this->call(ActivityTableSeeder::class);
        $this->call(TopicTableSeeder::class);
        $this->call(TopicCommentTableSeeder::class);
        $this->call(TimelineCommentTableSeeder::class);
        $this->call(NoticeTableSeeder::class);

        Model::reguard();
    }
}
