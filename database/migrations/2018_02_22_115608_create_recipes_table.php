<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{

    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
			$table->increments('id');

			// Russian language
            $table->string('title_ru')->nullable();
            $table->text('intro_ru')->nullable();
            $table->text('ingredients_ru')->nullable();
			$table->text('text_ru')->nullable();
            $table->bigInteger('ready_ru')->default(0);
			$table->boolean('approved_ru')->default(0);
			
			// English language
            $table->string('title_en')->nullable();
            $table->text('intro_en')->nullable();
            $table->text('ingredients_en')->nullable();
            $table->text('text_en')->nullable();
            $table->bigInteger('ready_en')->default(0);
			$table->boolean('approved_en')->default(0);

			// Other
			$table->integer('user_id')->unsigned()->default(1);
			$table->integer('meal_id')->unsigned()->default(1);
            $table->integer('time')->default(0);
            $table->bigInteger('views')->default(0);
            $table->bigInteger('likes')->default(0);
			$table->string('image')->default('default.jpg');
			$table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
