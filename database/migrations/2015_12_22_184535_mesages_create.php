<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MesagesCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("from");
            $table->unsignedInteger("to");
            $table->text("message")->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign("from")
                    ->references("id")
                    ->on("users")
                    ->onDelete("cascade");
            $table->foreign("to")
                    ->references("id")
                    ->on("users")
                    ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('messages');
    }
}
