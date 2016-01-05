<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BooksCreate extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger("user_id")->nullable();
            $table->string("book_id");
            $table->string("title");
            $table->text("desc")->nullable();
            $table->text("reviews")->nullable();
            $table->double("rating")->default(0.00);
            $table->text("image")->nullable();
            $table->string("year",4)->nullable();
            $table->string("publisher",80)->nullable();
            $table->string("author_name",50)->nullable();
            $table->string("author_id",20)->nullable();
            $table->string("source",15)->nullable();
            $table->string("subtitle",100)->nullable();
            $table->string("isbn")->nullable();
            $table->enum("is_wishlist", [0, 1])->default(0);      # 0-> no ,1->yes
            $table->enum("is_fav", [0, 1])->default(0);             # 0->no , 1->yes
            $table->enum("is_lendable", [0, 1])->default(0);    # 0->no , 1->yes
            $table->enum("is_sellable", [0, 1])->default(0);      # 0->no , 1->yes
            $table->softDeletes();
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
        Schema::drop('books');
    }

}
