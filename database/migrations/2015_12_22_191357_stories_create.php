<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoriesCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->nullable();
            $table->string("title",100)->nullable();
            $table->text("desc")->nullable();
            $table->text("excerpt")->nullable();
            $table->datetime("published_date")->nullable();
            # 0->unapproved , 1->approved
            $table->enum("approved", [0, 1])->default(0);
            # 0-> by admin, 1-> by users
            $table->enum("is_admin", [0, 1])->default(0);
            $table->softDeletes();
            $table->text("categories");
            $table->timestamps();
            
//            $table->primary("id");
            $table->foreign("user_id")
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
        Schema::drop('stories');
    }
}
