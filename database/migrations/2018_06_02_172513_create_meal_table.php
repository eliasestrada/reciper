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
			$table->string('title', 20);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meal');
    }
}
