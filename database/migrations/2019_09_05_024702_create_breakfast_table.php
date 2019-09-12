<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreakfastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakfast', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('weight')->nullable();
            $table->string('id_number')->nullable();
            $table->string('filters')->nullable();
            $table->string('filters_additional_sides')->nullable();
            $table->string('sizes', 255)->nullable();
            $table->integer('status')->nullable();
            $table->string('category')->nullable();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('breakfast');
    }
}
