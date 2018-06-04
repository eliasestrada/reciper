<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealTable extends Migration
{
    public function up()
    {
        Schema::create('meal', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name_en', 20);
			$table->string('name_ru', 20);
        });
    }

    public function down()
    {
        Schema::dropIfExists('meal');
    }
}
