<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger( 'train_id' )->unsigned();
            $table->bigInteger( 'user_id' )->unsigned();
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
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('train_id')->references('id')->on('trains');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
