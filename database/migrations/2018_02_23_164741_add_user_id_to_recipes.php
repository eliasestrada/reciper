<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToRecipes extends Migration
{

    public function up()
    {
        Schema::table('recipes', function($table) {
            $table->integer('user_id');
        });
    }


    public function down()
    {
        Schema::table('recipes', function($table) {
            $table->dropColumn('user_id');
        });
    }
}
