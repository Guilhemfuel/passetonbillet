<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('question_en');
            $table->string('question_fr');
            $table->mediumText( 'answer_en' );
            $table->mediumText(  'answer_fr' );
            $table->string('tags_en');
            $table->string('tags_fr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('help_questions');
    }
}
