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
            $table->string('file_type')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_location')->nullable();
            $table->string('protein')->nullable();
            $table->string('calories')->nullable();
            $table->string('food_name')->nullable();
            $table->string('fat')->nullable();
            $table->string('carb')->nullable();
            $table->string('grams')->nullable();
            $table->string('status')->nullable();
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
