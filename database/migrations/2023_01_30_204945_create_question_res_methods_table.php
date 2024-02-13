<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionResMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_res_methods', function (Blueprint $table) {
            $table->integer('access_res_id')->unsigned();
            $table->integer('access_question_id')->length(10)->unsigned();
            $table->text('access_yes')->nullable();
            $table->text('access_no')->nullable();
            $table->integer('access_company_id')->length(10)->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_res_methods');
    }
}
