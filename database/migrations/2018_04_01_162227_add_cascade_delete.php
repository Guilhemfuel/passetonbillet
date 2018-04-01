<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCascadeDelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'tickets', function ( Blueprint $table ) {
            // We allow to remove and re-add ticket
            $table->dropUnique( 'tickets_eurostar_code_buyer_name_train_id_unique' );
        });
        Schema::table( 'messages', function ( Blueprint $table ) {
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
        Schema::table( 'tickets', function ( Blueprint $table ) {
            $table->unique(array('eurostar_code', 'buyer_name','train_id'));
        });
        Schema::table( 'messages', function ( Blueprint $table ) {
            $table->dropColumn('deleted_at');
        });
    }
}
