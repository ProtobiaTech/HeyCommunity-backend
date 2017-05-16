<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMomentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('collect_id')->index()->unsigned();
            $table->foreign('collect_id')->references('id')->on('collects');
            $table->integer('type_id')->index()->unsigned()->default(1);
            $table->text('content');
            $table->integer('like_num')->default(0);
            $table->integer('view_num')->default(0);
            $table->integer('comment_num')->default(0);

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
        Schema::drop('moments');
    }
}
