<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendTicketsToAddOptionnalProviderIdForThalys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'tickets', function ( $table ) {
            $table->string( 'provider_id' )->nullable();
            $table->boolean( 'manual' )->default( false );
            $table->string('provider_code')->nullable(true)->change();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'tickets', function ( $table ) {
            $table->dropColumn( 'provider_id' );
            $table->dropColumn( 'manual' );
            $table->string('provider_code')->nullable(false)->change();
        } );
    }
}
