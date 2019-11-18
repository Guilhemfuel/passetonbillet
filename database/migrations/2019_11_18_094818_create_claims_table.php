<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->bigInteger( 'ticket_id' )->unsigned();
            $table->foreign('ticket_id')->references('id')->on('tickets');

            $table->bigInteger( 'seller_id' )->unsigned();
            $table->foreign('seller_id')->references('id')->on('users');

            $table->bigInteger( 'purchaser_id' )->unsigned();
            $table->foreign('purchaser_id')->references('id')->on('users');

            $table->string('status')->nullable();

            $table->text('claim_purchaser')->nullable();
            $table->text('claim_seller')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('claims');
    }
}
