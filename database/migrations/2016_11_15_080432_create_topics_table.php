<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('topic_node_id')->index()->unsigned();
            $table->foreign('topic_node_id')->references('id')->on('topic_nodes');
            $table->string('title', 191);
            $table->text('content');
            $table->integer('star_num')->default(0);
            $table->integer('thumb_up_num')->default(0);
            $table->integer('thumb_down_num')->default(0);
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
        Schema::drop('topics');
    }
}
