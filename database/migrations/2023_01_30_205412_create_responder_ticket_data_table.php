<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponderTicketDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responder_ticket_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('responder_id')->length(10)->unsigned();
            $table->text('response');
            $table->text('methods');
            $table->integer('company_id')->length(10)->unsigned();
            $table->integer('ticket_id')->length(10)->unsigned();
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
        Schema::dropIfExists('responder_ticket_data');
    }
}
