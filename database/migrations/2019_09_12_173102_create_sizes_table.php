<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('calorie')->nullable();
            $table->integer('protein')->nullable();
            $table->integer('carbohydrates')->nullable();
            $table->integer('fats')->nullable();
            $table->integer('saturated_fat')->nullable();
            $table->integer('sugars')->nullable();
            $table->integer('sodium')->nullable();
            $table->string('size')->nullable();
            $table->integer('price')->nullable();
            $table->integer('meal_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
