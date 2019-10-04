<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListSelectedMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_selected_meals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->nullable();
            $table->integer('day_1_meal_id')->nullable();
            $table->integer('day_2_meal_id')->nullable();
            $table->integer('day_3_meal_id')->nullable();
            $table->integer('day_4_meal_id')->nullable();
            $table->integer('day_5_meal_id')->nullable();
            $table->integer('day_6_meal_id')->nullable();
            $table->integer('day_7_meal_id')->nullable();
            $table->string('day_range')->nullable();
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
        Schema::dropIfExists('list_selected_meals');
    }
}
