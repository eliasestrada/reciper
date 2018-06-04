<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitleTable extends Migration
{
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('title');
			$table->text('text');
        });
    }


    public function down()
    {
        Schema::dropIfExists('titles');
    }
}
