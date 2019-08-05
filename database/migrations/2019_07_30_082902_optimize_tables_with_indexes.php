<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OptimizeTablesWithIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stations', function (Blueprint $table) {
            // To search station relationships faster
            $table->index(['parent_station_id','deleted_at','is_suggestable']);
        });
        Schema::table('tickets', function (Blueprint $table) {
            // To compute number of successfully sold ticket faster
            $table->index(['user_id','sold_to_id','deleted_at']);
        });
        Schema::table('tickets', function (Blueprint $table) {
            // To find tickets faster from trains
            $table->index(['train_id','deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stations', function (Blueprint $table) {
            $table->dropIndex(['parent_station_id','deleted_at','is_suggestable']);
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['user_id','sold_to_id','deleted_at']);
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['train_id','deleted_at']);
        });
    }
}
