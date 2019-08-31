<?php

use Illuminate\Support\Facades\Schema;
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
            $table->timestamps();
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
            $table->engine = 'InnoDB';
            $table->string('email')->unique();
            $table->string('password');

            // editable
            $table->string('name');

            $table->longText('permissions')->nullable();

            $table->dateTime('last_login_date')->nullable();            
            $table->boolean('is_disabled')->default(false);
            $table->string('forgot_password_code')->default('');
            $table->timestamp('forgot_password_date')->nullable();
            $table->integer('num_attempts')->default(0);
            $table->string('division')->nullable();
            $table->string('section')->nullable();

        });

        $user_id = DB::table('users')->insertGetId([
            'email' => 'rod@acctechnology.ph',
            'password' => bcrypt ( 'jahrakal' ),
            'name' => 'Super Administrator',
            'permissions' => json_encode(array(
                'temporary' => true
            ))
        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
