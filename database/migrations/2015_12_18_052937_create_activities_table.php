<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('tenant_id')->index()->unsigned();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string('title');
            $table->string('avatar');
            $table->text('content');

            $table->timestamp('start_date');
            $table->timestamp('end_date');

            $table->softDeletes();
            $table->timestamps();
        });


        // default data
        Model::unguard();

        $users = \App\User::lists('id')->toArray();
        $tenants = \App\Tenant::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 28) as $index) {
            \App\Activity::create([
                'user_id'       =>      $faker->randomElement($users),
                'tenant_id'     =>      $faker->randomElement($tenants),
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('<br>', $faker->paragraphs(random_int(2, 10))),
                'avatar'        =>      $faker->imageUrl(200, 200),

                'start_date'    =>      $faker->dateTimeBetween('- 10 days', 'now'),
                'end_date'      =>      $faker->dateTimeBetween('now', '+ 30 days'),
            ]);
        }

        Model::reguard();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('activities');
    }
}
