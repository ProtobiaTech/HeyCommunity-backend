<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficialBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('official_blogs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_id')->index()->unsigned();
            $table->foreign('admin_id')->references('id')->on('admins');
            $table->string('title', 191);
            $table->text('content');
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
        Schema::drop('official_blogs');
    }
}
