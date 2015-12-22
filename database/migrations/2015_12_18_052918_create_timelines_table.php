<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('tenant_id')->index()->unsigned();
            $table->foreign('tenant_id')->references('id')->on('tenants');
            $table->string('title');
            $table->string('attachment');
            $table->text('content');

            $table->softDeletes();
            $table->timestamps();
        });


        // default data
        Model::unguard();

        $users = \App\User::lists('id')->toArray();
        $tenants = \App\Tenant::lists('id')->toArray();

        $faker = Faker\Factory::create();
        foreach (range(1, 28) as $index) {
            \App\Timeline::create([
                'user_id'       =>      $faker->randomElement($users),
                'tenant_id'     =>      $faker->randomElement($tenants),
                'title'         =>      $faker->sentence(),
                'content'       =>      implode('<br>', $faker->paragraphs(random_int(1,5))),
                'attachment'    =>      $faker->imageUrl(),
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
        Schema::drop('timelines');
    }
}
