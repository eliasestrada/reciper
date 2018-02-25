<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageToRecipes extends Migration
{

    public function up()
    {
        Schema::table('recipes', function($table) {
            $table->string('image');
        });
    }


    public function down()
    {
        Schema::table('recipes', function($table) {
            $table->dropColumn('image');
        });
    }
}
