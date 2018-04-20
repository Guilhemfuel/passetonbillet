<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTicketsTableAddMarkedAsFraudAt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            $table->timestamp('marked_as_fraud_at')->nullable(true);
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
            $table->dropColumn('marked_as_fraud_at');
        } );
    }
}
