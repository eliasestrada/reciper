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
            $table->string('title')->nullable();
            $table->text('intro')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('advice')->nullable();
            $table->text('text')->nullable();
            $table->integer('time')->default(0);
            $table->string('category')->default('Разное');
            $table->bigInteger('views')->default(0);
            $table->bigInteger('likes')->default(0);
            $table->bigInteger('ready')->default(0);
            $table->boolean('approved')->default(0);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
