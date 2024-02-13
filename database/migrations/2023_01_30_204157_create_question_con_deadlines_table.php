<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionConDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_con_deadlines', function (Blueprint $table) {
            $table->id();
            $table->integer('question_con_id')->length(10)->unsigned();
            $table->integer('ticket_id')->length(10)->unsigned();
            $table->date('end_date');
            $table->text('summary')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('viewed')->length(1)->nullable()->default(0);
            $table->tinyInteger('emailed')->length(1)->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_con_deadlines');
    }
}
