<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyTicketsTableRemoveNullBuyerEmail extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            $table->string('buyer_email')->nullable(true)->change();
            $table->string('buyer_name')->nullable(true)->change();
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
            $table->string('buyer_email')->nullable(false)->change();
            $table->string('buyer_name')->nullable(false)->change();
        } );
    }
}

