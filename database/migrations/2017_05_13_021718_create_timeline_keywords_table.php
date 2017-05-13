<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimelineKeywordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_keywords', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timeline_id')->index()->unsigned();
            $table->string('keyword')->comment('关键词');
            $table->double('score')->comment('权重');
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
        Schema::drop('timeline_keywords');
    }
}
