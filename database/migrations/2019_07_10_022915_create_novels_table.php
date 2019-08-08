<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('novel_title');
            $table->text('novel_introduction');
            $table->string('novel_maincategory');
            $table->string('novel_subcategory');
            $table->integer('end_check')->nullable();
            $table->integer('user_id')->unsigned(); //登録者ID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //紐付け
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
        Schema::dropIfExists('novels');
    }
}
