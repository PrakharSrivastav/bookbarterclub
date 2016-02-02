<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTypeColumn extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('messages', function ($table) {
            $table->dropColumn('type');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->enum('type', ['0', '1', '2'])->default('0');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('messages', function (Blueprint $table) {
            $table->enum('type', ['0', '1'])->default('0');
        });
    }
}
