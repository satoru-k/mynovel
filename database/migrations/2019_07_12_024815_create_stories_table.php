<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_num');
            $table->integer('novel_id');
            $table->integer('user_id')->unsigned(); //登録者ID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //紐付け
            $table->string('story_title');
            $table->text('story_body');
            $table->text('foreword')->nullable();
            $table->text('afterword')->nullable();
            $table->string('chapter')->nullable();
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
        Schema::dropIfExists('stories');
    }
}
