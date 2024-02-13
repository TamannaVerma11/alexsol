<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionConMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_con_methods', function (Blueprint $table) {
            $table->integer('access_con_id')->unsigned();
            $table->integer('access_question_id')->length(10)->unsigned();
            $table->text('access_yes')->nullable();
            $table->text('access_no')->nullable();
            $table->integer('access_company_id')->nullable()->length(10)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_con_methods');
    }
}
