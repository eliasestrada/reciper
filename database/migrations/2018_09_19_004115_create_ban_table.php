<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ban', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visitor_id');
            $table->unsignedMediumInteger('days');
            $table->string('message', config('validation.feedback.ban.message.max'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ban');
    }
}
