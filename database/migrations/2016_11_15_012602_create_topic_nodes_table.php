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
            $table->integer('parent_id')->index()->default(0);
            $table->string('name', 191);
            $table->text('description');

            $table->softDeletes();
            $table->timestamps();
        });

        $nodes = [
            ['id' => 1, 'parent_id' => 0, 'name' => 'Default'],
        ];

        Model::unguard();
        foreach ($nodes as $node) {
            \App\TopicNode::create([
                'id'        =>      $node['id'],
                'parent_id' =>      $node['parent_id'],
                'name'      =>      $node['name'],
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
        Schema::drop('topic_nodes');
    }
}
