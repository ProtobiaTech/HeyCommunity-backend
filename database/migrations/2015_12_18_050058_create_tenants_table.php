<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_name');
            $table->string('domain')->unique()->nullable();
            $table->string('sub_domain')->unique();
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password', 60);
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();

        \App\Tenant::create([
            'site_name'     =>  'Demo Community',
            'domain'        =>  'demo.hey-community.cn',
            'sub_domain'    =>  'demo.hey-community.online',
            'email'         =>  'supgeek.rod@gmail.com',
            'phone'         =>  '12312341234',
            'password'      =>  bcrypt('hey community'),
        ]);

        \App\Tenant::create([
            'site_name'     =>  'Dev Community',
            'domain'        =>  'demo.hey-community.local',
            'sub_domain'    =>  'dev.hey-community.cn',
            'email'         =>  'dev@hey-community.cn',
            'phone'         =>  '12312341234',
            'password'      =>  bcrypt('hey community'),
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
        Schema::drop('tenants');
    }
}
