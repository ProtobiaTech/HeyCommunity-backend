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
            $table->string('email', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('password', 60);
            $table->integer('is_admin')->default(0);
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();

        \App\User::create([
            'nickname'      =>      'Admin',
            'avatar'        =>      '/assets/images/userAvatar-default.png',
            'email'         =>      'admin@hey-community.cn',
            'phone'         =>      '12312341234',
            'password'      =>      Hash::make('admin1234'),
            'is_admin'      =>      1,
        ]);

        Model::reguard();
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
