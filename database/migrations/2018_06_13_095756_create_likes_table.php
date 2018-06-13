<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('visitor_id')->unsigned();
			$table->foreign('visitor_id')->references('id')->on('visitors');

			$table->integer('recipe_id')->unsigned();
			$table->foreign('recipe_id')->references('id')->on('recipes');
        });
    }


    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
