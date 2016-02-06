<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSenderColumnsForMsg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->integer('sender')->unsigned()->nullable()->default(12);
            $table->string('sender_name', 500)->nullable();
            $table->string('sender_img', 500)->nullable();
            $table->string('reader_name', 500)->nullable();
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
            $table->dropColumn('sender');
            $table->dropColumn('sender_name');
            $table->dropColumn('sender_img');
            $table->dropColumn('reader_name');
        });
    }
}
