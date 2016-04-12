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
            $table->string('title', 191);
            $table->string('avatar', 191);
            $table->text('content');

            $table->timestamp('start_date');
            $table->timestamp('end_date');

            $table->integer('like_num');
            $table->integer('attend_num');
            $table->integer('comment_num');

            $table->softDeletes();
            $table->timestamps();
        });
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
