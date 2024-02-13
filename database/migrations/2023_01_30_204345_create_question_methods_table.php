<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_methods', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_response')->length(1)->nullable()->default(0);
            $table->integer('question_id')->length(10)->unsigned();
            $table->text('yes')->nullable();
            $table->text('no')->nullable();
            $table->integer('company_id')->length(10)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_methods');
    }
}
