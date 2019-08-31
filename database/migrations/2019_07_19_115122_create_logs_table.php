<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/*
*       For creation of user logs **cla-dev
*   
*
*/

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->engine = 'InnoDB';

            /*
                logs_user_id : references the user to which log is pointed to
                type: references type of log: login, logout, add, delete, update, vie
                object: to which object is the type pointed to. null if login/logout. 
            */
            $table->string('client');
            $table->integer('logs_user_id');
            $table->string('type');
            $table->string('object')->nullable();
            $table->string('info')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
