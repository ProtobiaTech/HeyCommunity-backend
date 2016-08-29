<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('wx_open_id', 191)->nullable();
            $table->string('nickname', 191);
            $table->string('avatar', 191);
            $table->string('bio', 191);
            $table->integer('gender');
            $table->string('email', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('password', 60);
            $table->integer('is_admin')->default(0);
            $table->rememberToken();

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
        Schema::drop('users');
    }
}
