<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visitor_id');
            $table->string('name', config('valid.settings.general.name.max'));
            $table->string('status', config('valid.settings.general.status.max'))->nullable();
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->unsignedSmallInteger('xp')->default(1);
            $table->integer('streak_days')->default(0);
            $table->decimal('popularity', 8, 1)->default(0);
            $table->timestamp('streak_check')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('notif_check')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('online_check')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('contact_check')->nullable();
            $table->timestamps();
            $table->string('image')->default('default.jpg');
            $table->string('password', 250);
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
