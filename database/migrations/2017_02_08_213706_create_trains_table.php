<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trains', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->integer('departure_city')->unsigned();
            $table->integer('arrival_city')->unsigned();
            $table->date('departure_date');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('departure_city')->references('id')->on('stations');
            $table->foreign('arrival_city')->references('id')->on('stations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trains');
    }
}
