<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\Model;

class CreateTopicNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topic_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 191);
            $table->text('description');
            $table->integer('parent_id')->nullable()->index();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Model::unguard();


        //
        $rootNode = \App\TopicNode::create([
            'name'      =>      env('LOCALE') === 'zh-CN' ? '默认' : 'Default',
        ]);
        $rootNode->makeRoot();

        $node = \App\TopicNode::create([
            'name'      =>      env('LOCALE') === 'zh-CN' ? '默认1' : 'Default 1',
        ]);
        $node->makeChildOf($rootNode);


        Model::reguard();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('topic_nodes');
    }
}
