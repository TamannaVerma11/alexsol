<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_contents', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_response')->length(1)->nullable()->default(0);
            $table->integer('question_id')->length(10)->unsigned();
            $table->string('name', 1000)->nullable();
            $table->longText('tips_yes')->nullable();
            $table->longText('tips_no')->nullable();
            $table->text('option1')->nullable();
            $table->text('option2')->nullable();
            $table->text('option3')->nullable();
            $table->text('option4')->nullable();
            $table->text('option5')->nullable();
            $table->text('option6')->nullable();
            $table->integer('language_id')->length(10)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_contents');
    }
}
