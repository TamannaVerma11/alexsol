<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketDeadlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_deadlines', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id')->unsigned();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('ticket_deadlines');
    }
}
