<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uic')->nullable();
            $table->integer('uic8_sncf')->nullable();
            $table->string('sncf_id')->nullable();
            $table->string('name');
            $table->string('name_fr')->nullable();
            $table->string('name_en')->nullable();
            $table->string('slug');
            $table->string('country',2);
            $table->string('timezone');
            $table->boolean('is_suggestable');


            $table->integer('parent_station_id')->nullable();
            $table->integer('same_as')->nullable();

            $table->jsonb('data');

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
        Schema::dropIfExists('stations');
    }
}
