<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPassbookLinkToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            // We allow to remove and re-add ticket
            $table->string('passbook_link')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            // We allow to remove and re-add ticket
            $table->drop( 'passbook_link' );
        });
    }
}
