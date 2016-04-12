<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->index()->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('tenant_id')->index()->unsigned();
            $table->foreign('tenant_id')->references('id')->on('tenants');

            $table->string('content', 191);

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
        Schema::drop('activity_comments');
    }
}
