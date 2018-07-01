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
			$table->unsignedInteger('visitor_id');
			$table->foreign('visitor_id')->references('id')->on('visitors');

			$table->unsignedInteger('recipe_id');
			$table->foreign('recipe_id')->references('id')->on('recipes');
        });
    }


    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
