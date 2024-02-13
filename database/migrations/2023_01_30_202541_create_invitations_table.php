<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->text('code');
            $table->string('name');
            $table->string('email');
            $table->string('phone', 50);
            $table->tinyInteger('status')->nullable()->default(0);
            $table->integer('company_id')->length(10)->unsigned()->nullable()->default(0);
            $table->datetime('accept_date')->nullable();
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
        Schema::dropIfExists('invitations');
    }
}
