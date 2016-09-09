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
            $table->string('site_name', 191);
            $table->string('domain', 191)->unique()->nullable();
            $table->string('sub_domain', 191)->unique();
            $table->string('email', 191)->unique();
            $table->string('phone', 191)->unique();
            $table->string('password', 60);
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });

        /*
        Model::unguard();

        \App\Tenant::create([
            'site_name'     =>  'Dev Community',
            'domain'        =>  'dev.hey-community.local',
            'sub_domain'    =>  'dev.hey-community.com',
            'email'         =>  'dev@hey-community.com',
            'phone'         =>  '12312341234',
            'password'      =>  bcrypt('hey community'),
        ]);

        \App\Tenant::create([
            'site_name'     =>  'Demo Community',
            'domain'        =>  'demo.hey-community.com',
            'sub_domain'    =>  'demo.hey-community.cn',
            'email'         =>  'demo@hey-community.com',
            'phone'         =>  '12311112222',
            'password'      =>  bcrypt('hey community'),
        ]);

        Model::reguard();
         */
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
