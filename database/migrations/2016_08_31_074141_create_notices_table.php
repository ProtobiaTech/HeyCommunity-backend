<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('initiator_user_id')->index()->unsigned();
            $table->foreign('initiator_user_id')->references('id')->on('users');

            $table->integer('entity_id')->index()->unsigned();
            $table->string('entity_type', 191)->index();

            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('notice_types');
            $table->integer('is_checked')->unsigned()->default(0);

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
        Schema::drop('notices');
    }
}
