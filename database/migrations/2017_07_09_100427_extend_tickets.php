<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            $table->bigInteger( 'train_id' );
            $table->bigInteger( 'user_id' );
            $table->string('user_notes', 140)->nullable();
            $table->integer('price')->nullable();
            $table->string('currency')->nullable();
            $table->integer('flexibility');
            $table->string('class');
            $table->integer('bought_price');
            $table->string('bought_currency');
            $table->boolean('inbound');
            $table->string('eurostar_code',6);
            $table->string('buyer_email');
            $table->string('buyer_name');
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            $table->dropColumn( 'train_id' );
            $table->dropColumn( 'user_id' );
            $table->dropColumn( 'user_notes' );
            $table->dropColumn( 'price' );
            $table->dropColumn( 'currency' );
            $table->dropColumn( 'flexibility' );
            $table->dropColumn( 'class' );
            $table->dropColumn( 'bought_price' );
            $table->dropColumn( 'bought_currency' );
            $table->dropColumn( 'inbound' );
            $table->dropColumn( 'eurostar_code' );
            $table->dropColumn( 'buyer_email' );
            $table->dropColumn( 'buyer_name' );
        } );
    }
}
