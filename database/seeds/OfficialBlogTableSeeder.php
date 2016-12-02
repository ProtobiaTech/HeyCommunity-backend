<?php

use Illuminate\Database\Seeder;

class OfficialBlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 68) as $index) {
            $text = implode('', $faker->paragraphs(random_int(4, 9)));
            $data[] = [
                'admin_id'      =>  1,
                'title'         =>      $faker->sentence(6),
                'content'       =>      $text,
                'md_content'    =>      $text,

                'created_at'    =>  $faker->dateTimeThisMonth(),
                'updated_at'    =>  $faker->dateTimeThisMonth(),
            ];
        }
        \App\OfficialBlog::insert($data);
    }
}
