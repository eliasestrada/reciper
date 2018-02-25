<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8mb4_general_ci';
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('intro')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('advice')->nullable();
            $table->text('text')->nullable();
            $table->integer('time')->unsigned();
            $table->string('category');
            $table->bigInteger('views');
            $table->bigInteger('likes');
            $table->boolean('approved');
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
        Schema::dropIfExists('recipes');
    }
}
