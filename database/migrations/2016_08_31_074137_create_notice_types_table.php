<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateNoticeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notice_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);

            $table->softDeletes();
            $table->timestamps();
        });

        $noticeTypes = [
            ['id' => 10, 'name' => 'timeline_like'],
            ['id' => 11, 'name' => 'timeline_comment'],
            ['id' => 12, 'name' => 'timeline_comment_comment'],

            ['id' => 20, 'name' => 'topic_like'],
            ['id' => 21, 'name' => 'topic_comment'],
            ['id' => 22, 'name' => 'topic_comment_comment'],
        ];
        Model::unguard();

        foreach ($noticeTypes as $type) {
            \App\NoticeType::create([
                'id'        =>      $type['id'],
                'name'      =>      $type['name'],
            ]);
        }

        Model::reguard();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('notice_types');
    }
}
