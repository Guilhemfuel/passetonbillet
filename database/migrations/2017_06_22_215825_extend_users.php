<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->dropColumn( 'name' );
            $table->string( 'first_name' );
            $table->string( 'last_name' );
            $table->smallInteger( 'gender' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->date('birthdate')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('linkedin_id')->nullable();
            $table->boolean('identity_confirmed')->nullable();
            $table->integer('status');

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'users', function ( Blueprint $table ) {
            $table->string( 'name' );
            $table->dropColumn( 'first_name' );
            $table->dropColumn( 'last_name' );
            $table->dropColumn( 'gender' );
            $table->dropColumn( 'phone' );
            $table->dropColumn( 'birthdate' );
            $table->dropColumn( 'facebook_id' );
            $table->dropColumn( 'linkedin_id' );
            $table->dropColumn( 'identity_confirmed' );
            $table->dropColumn( 'status' );
        } );
    }
}
