<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{

    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('meal_id')->default(1);
            $table->unsignedInteger('ru_approver_id')->default(0);
            $table->unsignedInteger('en_approver_id')->default(0);

            // Russian language
            $table->string('title_ru', config('valid.recipes.title.max') + 20)->nullable();
            $table->text('intro_ru')->nullable();
            $table->text('ingredients_ru')->nullable();
            $table->text('text_ru')->nullable();
            $table->boolean('ready_ru')->default(0);
            $table->boolean('approved_ru')->default(0);

            // English language
            $table->string('title_en', config('valid.recipes.title.max') + 20)->nullable();
            $table->text('intro_en')->nullable();
            $table->text('ingredients_en')->nullable();
            $table->text('text_en')->nullable();
            $table->boolean('ready_en')->default(0);
            $table->boolean('approved_en')->default(0);

            // Other
            $table->unsignedSmallInteger('time')->default(0);
            $table->string('image')->default('default.jpg');
            $table->boolean('simple')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
