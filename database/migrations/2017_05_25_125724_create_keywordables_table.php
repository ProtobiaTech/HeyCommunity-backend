<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keywordables', function (Blueprint $table) {
            $table->unsignedInteger('keyword_id');
            $table->unsignedInteger('keywordable_id');
            $table->string('keywordable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('keywordables');
    }
}
