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
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password', 60);
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });


        // default data
        Model::unguard();

        $faker = Faker\Factory::create();
        \App\User::create([
            'nickname'      =>      'Rod',
            'email'         =>      'supgeek.rod@gmail.com',
            'phone'         =>      '17090402884',
            'password'      =>      Hash::make('19940120.'),
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
