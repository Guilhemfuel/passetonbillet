<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminWarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_warnings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('action');
            $table->string('link');
            $table->jsonb('data')->default('{}');
            $table->bigInteger('done_by_id')->nullable();
            $table->timestamp('done_at')->nullable();

            $table->timestamps();
            $table->foreign('done_by_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_warnings');
    }
}
