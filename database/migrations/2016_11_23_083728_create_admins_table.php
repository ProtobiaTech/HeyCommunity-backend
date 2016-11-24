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
            $table->string('email', 191)->nullable();
            $table->string('password', 60);
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();
        \App\Admin::create([
            'nickname'          =>  env('ADMIN_NICKNAME', 'Admin'),
            'email'             =>  env('ADMIN_EMAIL', 'admin@hey-community.com'),
            'password'          =>  bcrypt(env('ADMIN_PASSWORD', 'hey community')),
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
