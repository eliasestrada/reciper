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
			$table->date('notif_check')->useCurrent();
			$table->date('contact_check')->useCurrent();
			$table->string('image');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('users');
    }
}
