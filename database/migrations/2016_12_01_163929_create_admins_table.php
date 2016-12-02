<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname', 191);
            $table->string('avatar', 191);
            $table->string('bio', 191);
            $table->integer('gender');
            $table->string('email', 191)->nullable();
            $table->string('phone', 191)->nullable();
            $table->string('password', 60);

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();

        \App\Admin::create([
            'nickname'          =>      'Rod',
            'avatar'            =>      '',
            'email'             =>      'rod@protobia.tech',
            'phone'             =>      '17090402884',
            'password'          =>      bcrypt('HeyCommunity2016'),
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
        Schema::drop('admins');
    }
}
