<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitleTable extends Migration
{
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            // Russian
            $table->string('title_ru')->nullable();
            $table->text('text_ru')->nullable();
            // English
            $table->string('title_en')->nullable();
            $table->text('text_en')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
