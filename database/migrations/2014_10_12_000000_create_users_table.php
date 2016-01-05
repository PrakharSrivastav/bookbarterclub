<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('password', 80);
            $table->string('latitude',20);
            $table->string('longitude',20);
            $table->softDeletes();
            # ENUM 0->inactive , 1->inactive
            $table->enum('active',[0,1])->default(0);   
            # Enum 0->unknown , 1->male, 2->female
            $table->enum('gender',[0,1,2])->default(0);
            $table->text('about')->nullable();
            $table->date('dob')->nullable();
            $table->text('fav_quote')->nullable();
            $table->string('img_path',50)->nullable();
            $table->text("pref_location")->nullable();
            # 0->no notification, 1->new notifications
            $table->enum("notif",[0,1])->default(0); 
            $table->integer("book_num")->default(0);
            # regular contact number
            $table->string("contact_num",20)->nullable();
            # sms cotact number
            $table->string("mobile_num",20)->nullable();
            # is profile detail public or private 0->public , 1->private :: public by default
            $table->enum("privacy",[0,1])->default(0);
            # agreed to terms and conditions 0->no ,1->yes :: 0 by default
            $table->enum("tnc",[0,1])->default(0);
            $table->rememberToken();
            $table->timestamps();
            
            
//            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
