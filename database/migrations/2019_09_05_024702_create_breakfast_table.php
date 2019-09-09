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
            $table->string('carbohydrate')->nullable();
            $table->string('fat')->nullable();
            $table->string('sugar')->nullable();
            $table->string('saturated_fat')->nullable();
            $table->string('sodium')->nullable();

            $table->string('calories_gram')->nullable();
            $table->string('protein_gram')->nullable();
            $table->string('carbohydrate_gram')->nullable();
            $table->string('sugar_gram')->nullable();
            $table->string('fat_gram')->nullable();
            $table->string('saturated_fa_gram')->nullable();
            $table->string('sodium_gram')->nullable();

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('weight')->nullable();

            $table->string('filter')->nullable();
            $table->string('ingredients')->nullable();
            $table->string('size')->nullable();
            $table->string('category')->nullable();
            $table->string('price')->nullable();
            $table->boolean('status');
       
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
