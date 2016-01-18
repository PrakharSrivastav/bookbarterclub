<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            # 0-> normal message, 1-> borrow, request
            $table->enum('type', ['0','1'])->default('0');
            // $table->enum('choices', ['foo', 'bar'])->nullable()->default(['foo', 'bar']);;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
