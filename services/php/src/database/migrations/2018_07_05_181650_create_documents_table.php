<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_ru', config('valid.docs.title.max'))->nullable();
            $table->string('title_en', config('valid.docs.title.max'))->nullable();
            $table->text('text_ru')->nullable();
            $table->text('text_en')->nullable();
            $table->boolean('ready_ru')->default(0);
            $table->boolean('ready_en')->default(0);
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
        Schema::dropIfExists('documents');
    }
}
