<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('admin')->default(0);
            $table->boolean('master')->default(0);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
