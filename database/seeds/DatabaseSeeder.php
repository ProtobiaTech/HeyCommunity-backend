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

        $this->call(TenantTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TimelineImgTableSeeder::class);
        $this->call(TimelineTableSeeder::class);
        $this->call(TimelineCommentTableSeeder::class);

        Model::reguard();
    }
}
