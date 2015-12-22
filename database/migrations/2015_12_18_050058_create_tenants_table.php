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
            $table->string('domain');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('password', 60);
            $table->rememberToken();

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();

        \App\Tenant::create([
            'site_name'         =>      'Hey Community Demo',
            'domain'            =>      'demo.hey-community.online',
            'email'             =>      'demo@hey-community.com',
            'password'          =>      Hash::make('hey community'),
        ]);
        \App\Tenant::create([
            'site_name'         =>      'Test Community Demo',
            'domain'            =>      'test.hey-community.online',
            'email'             =>      'test@hey-community.com',
            'password'          =>      Hash::make('hey community'),
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
