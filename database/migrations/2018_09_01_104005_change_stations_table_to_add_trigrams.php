<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStationsTableToAddTrigrams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stations',function($table){
            $table->text('n_grams');
            $table->text('n_grams_fr')->nullable();
            $table->text('n_grams_en')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stations',function($table){
            $table->dropColumn('n_grams');
            $table->dropColumn('n_grams_fr');
            $table->dropColumn('n_grams_en');

        });
    }
}
