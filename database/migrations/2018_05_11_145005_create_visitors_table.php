<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{

    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('recipes')->default(0);
            $table->integer('requests')->default(0);
            $table->ipAddress('ip');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('visitors');
    }
}
