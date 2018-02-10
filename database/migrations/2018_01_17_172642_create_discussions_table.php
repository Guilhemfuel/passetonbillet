<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger( 'ticket_id' )->unsigned();
            $table->bigInteger( 'buyer_id' )->unsigned();
            $table->integer('status')->default(0);
            $table->integer('price');
            $table->string('currency');


            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('buyer_id')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discussions');
    }
}
