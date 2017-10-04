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
            $table->string('email')->unique();
            $table->string('password');
            $table->string( 'first_name' );
            $table->string( 'last_name' );
            $table->smallInteger( 'gender' )->nullable();
            $table->string( 'phone_country' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->date('birthdate')->nullable();
            $table->string('language')->nullable();
            $table->string('location')->nullable();
            $table->string('picture')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('email_verified')->default('false');
            $table->string('email_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
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
