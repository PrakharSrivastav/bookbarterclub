<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrendingTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('trends', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('book_id')->nullable();
            $table->string('author')->nullable();
            $table->string('author_id')->nullable();
            $table->text('image');
            $table->string('rating');
            $table->string('excerpt')->nullable();
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('trends');
    }
}
