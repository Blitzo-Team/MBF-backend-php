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

            $table->integer('calorie')->dafault(0);
            $table->integer('protein')->dafault(0);
            $table->integer('carbohydrates')->dafault(0);
            $table->integer('fats')->dafault(0);
            $table->integer('saturated_fat')->dafault(0);
            $table->integer('sugars')->dafault(0);
            $table->integer('sodium')->dafault(0);
            $table->string('size')->nullable();
            $table->integer('price')->dafault(0);
            $table->integer('meal_id')->dafault(0);

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
