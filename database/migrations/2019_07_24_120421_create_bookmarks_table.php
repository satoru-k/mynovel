<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //登録者ID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //紐付け
            $table->integer('novel_id')->unsigned();
            $table->foreign('novel_id')->references('id')->on('novels')->onDelete('cascade'); //紐付け
            $table->integer('story_num')->nullable();
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
        Schema::dropIfExists('bookmarks');
    }
}
