<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdapatTicketStructureToAddOtherTrains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets',function($table){
            $table->boolean('correspondence')->default(false);
            $table->string('provider');

            $table->dropColumn('eurostar_code');
            $table->string('provider_code');

            $table->dropColumn('eurostar_ticket_number');
            $table->string('ticket_number')->nullable();

            $table->string('flexibility')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets',function($table){
            $table->dropColumn('correspondence');
            $table->dropColumn('provider');
            $table->dropColumn('ticket_number');
            $table->dropColumn('provider_code');

            $table->string('eurostar_code',6);
            $table->bigInteger('eurostar_ticket_number')->nullable();

            $table->dropColumn('flexibility');
        });
    }
}
