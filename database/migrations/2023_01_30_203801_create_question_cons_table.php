<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionConsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_cons', function (Blueprint $table) {
            $table->increments('question_con_id');
            $table->integer('category_id')->length(10)->unsigned()->nullable();
            $table->string('question_type', 15)->nullable()->default('yes-no');
            $table->tinyInteger('question_follow_up')->length(1)->nullable()->default(0);
            $table->tinyInteger('question_tip_on_yes')->length(1)->nullable()->default(0);
            $table->tinyInteger('question_tip_on_no')->length(1)->nullable()->default(0);
            $table->integer('question_yes_follow_up')->length(10)->nullable();
            $table->integer('question_no_follow_up')->length(10)->nullable();
            $table->integer('question_weight_yes')->nullable()->default(1);
            $table->integer('question_weight_no')->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_cons');
    }
}
