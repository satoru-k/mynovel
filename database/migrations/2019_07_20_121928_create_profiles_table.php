<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); //登録者ID
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //紐付け
            $table->string('ruby')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood')->nullable();
            $table->string('hobby')->nullable();
            $table->string('job')->nullable();
            $table->string('website')->nullable();
            $table->text('introduction')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
