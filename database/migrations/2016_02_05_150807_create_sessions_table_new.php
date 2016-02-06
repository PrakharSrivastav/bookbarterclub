<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionsTableNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('users', function ($table) {
            $table->dropColumn('img_path');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('img_path',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('img_path',50)->nullable();
        });
    }
}
