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
            $table->timestamps();
            $table->increments('id');
            $table->string('title');
            $table->text('intro');
            $table->text('ingredients');
            $table->text('advice');
            $table->text('text');
            $table->integer('time');
            $table->string('category');
            $table->integer('step');
            $table->integer('views');
            $table->boolean('approved');
            $table->boolean('edit');
            $table->integer('likes');
            $table->integer('reports');
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
