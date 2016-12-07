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
            $table->integer('enable_wechat_pa')->default(0);
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
        Schema::drop('tenants');
    }
}
