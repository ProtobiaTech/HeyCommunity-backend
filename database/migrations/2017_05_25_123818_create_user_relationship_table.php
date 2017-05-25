<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_relationship', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->unsigned()->nullable();
            $table->integer('from_user_id')->index()->unsigned();
            $table->integer('to_user_id')->index()->unsigned();
            $table->integer('is_block')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_relationship', function (Blueprint $table) {
            $table->dropForeign('user_relationship_from_user_id_foreign');
            $table->dropForeign('user_relationship_to_user_id_foreign');
        });
        Schema::drop('user_relationship');
    }
}
