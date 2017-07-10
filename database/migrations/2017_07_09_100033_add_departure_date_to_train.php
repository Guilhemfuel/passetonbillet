<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartureDateToTrain extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'trains', function ( Blueprint $table ) {
            $table->date( 'arrival_date' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'trains', function ( Blueprint $table ) {
            $table->dropColumn( 'arrival_date' );
        } );
    }
}
