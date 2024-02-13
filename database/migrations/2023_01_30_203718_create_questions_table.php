<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('is_response')->length(1)->nullable()->default(0);
            $table->integer('category_id')->length(10)->unsigned()->nullable();
            $table->string('type', 15)->nullable()->default('yes-no');
            $table->tinyInteger('follow_up')->length(1)->nullable()->default(0);
            $table->tinyInteger('tip_on_yes')->length(1)->nullable()->default(0);
            $table->tinyInteger('tip_on_no')->length(1)->nullable()->default(0);
            $table->integer('yes_follow_up')->length(10)->unsigned()->nullable();
            $table->integer('no_follow_up')->length(10)->unsigned()->nullable();
            $table->integer('weight_yes')->length(10)->unsigned()->nullable()->default(1);
            $table->integer('weight_no')->length(10)->unsigned()->nullable()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
