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
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password', 60);
            $table->integer('is_admin')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });


        Model::unguard();

        // administrator
        \App\User::create([
            'nickname'      =>  'admin',
            'email'         =>  'admin@hey-community.online',
            'password'      =>  bcrypt('hey community'),
            'is_admin'      =>  true,
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
