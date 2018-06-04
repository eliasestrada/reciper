<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('admin')->default(0);
            $table->boolean('author')->default(0);
            $table->string('password');
			$table->rememberToken();
			$table->timestamp('notif_check')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->timestamp('contact_check')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('image')->default('default.jpg');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
