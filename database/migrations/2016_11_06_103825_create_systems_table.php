<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('community_name');
            $table->integer('enable_wechat_pa')->default(0);
            $table->string('wx_app_id')->nullable();
            $table->string('wx_app_secret')->nullable();
            $table->string('wx_temp_notice_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();
        \App\System::create([
            'id'                =>  1,
            'community_name'    =>  env('COMMUNITY_NAME', 'New Community'),
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
        Schema::drop('systems');
    }
}
