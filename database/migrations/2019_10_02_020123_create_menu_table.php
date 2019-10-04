<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->boolean('is_archived')->default(1);
            // $table->integer('day_2')->nullable();
            // $table->integer('day_3')->nullable();
            // $table->integer('day_4')->nullable();
            // $table->integer('day_5')->nullable();
            // $table->integer('day_6')->nullable();
            // $table->integer('day_7')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
