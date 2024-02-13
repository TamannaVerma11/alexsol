<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionResContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_res_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('question_res_id')->unsigned();
            $table->string('question_name', 1000)->nullable();
            $table->longText('question_tips_yes')->nullable();
            $table->longText('question_tips_no')->nullable();
            $table->text('question_option1')->nullable();
            $table->text('question_option2')->nullable();
            $table->text('question_option3')->nullable();
            $table->text('question_option4')->nullable();
            $table->text('question_option5')->nullable();
            $table->text('question_option6');
            $table->string('lang_code', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_res_contents');
    }
}
