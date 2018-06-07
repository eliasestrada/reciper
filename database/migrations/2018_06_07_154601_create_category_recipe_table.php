<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryRecipeTable extends Migration
{
    public function up()
    {
        Schema::create('category_recipe', function (Blueprint $table) {
			$table->integer('category_id')->unsigned();
			$table->foreign('category_id')->references('id')->on('categories');
			$table->integer('recipe_id')->unsigned();
			$table->foreign('recipe_id')->references('id')->on('recipes');
        });
    }


    public function down()
    {
        Schema::dropIfExists('category_recipe');
    }
}
