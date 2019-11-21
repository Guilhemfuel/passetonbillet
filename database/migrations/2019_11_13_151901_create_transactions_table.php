<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('transaction_mangopay')->nullable();
            $table->string('status')->nullable();

            $table->integer('wallet_id');
            $table->bigInteger( 'seller_id' )->unsigned();
            $table->bigInteger( 'purchaser_id' )->unsigned();
            $table->bigInteger( 'ticket_id' )->unsigned();

            $table->foreign('seller_id')->references('id')->on('users');
            $table->foreign('purchaser_id')->references('id')->on('users');
            $table->foreign('ticket_id')->references('id')->on('tickets');

            $table->string('status_refund')->nullable();
            $table->string('refund_id')->nullable();

            $table->string('status_payout')->nullable();
            $table->string('payout_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
