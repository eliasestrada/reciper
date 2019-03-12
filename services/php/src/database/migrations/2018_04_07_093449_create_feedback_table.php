<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{

    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_report')->default(0);
            $table->string('email')->nullable();
            $table->integer('visitor_id');
            $table->integer('recipe_id')->nullable();
            $table->string('lang', 2);
            $table->text('message');
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
}
