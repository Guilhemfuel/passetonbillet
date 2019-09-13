<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRangeToAlerts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->renameColumn('travel_date','travel_date_start');
            $table->date('travel_date_end')->nullable();
        });

        // Now set alert end date for all existing alerts
        foreach (\App\Models\Alert::all() as $alert) {
            $alert->travel_date_end = $alert->travel_date_start;
            $alert->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alerts', function (Blueprint $table) {
            $table->renameColumn('travel_date_start','travel_date');
            $table->dropColumn('travel_date_end');
        });
    }
}
