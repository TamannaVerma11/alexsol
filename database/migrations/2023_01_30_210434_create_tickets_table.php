<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->length(10)->unsigned();
            $table->integer('company_id')->length(10)->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->text('response')->nullable();
            $table->text('summary')->nullable();
            $table->text('review')->nullable();
            $table->text('rating')->nullable();
            $table->text('methods')->nullable();
            $table->string('status', 30)->nullable()->default('saved');
            $table->datetime('time')->useCurrent();
            $table->timestamp('close_time')->nullable();
            $table->integer('review_status')->nullable()->default(0);
            $table->integer('rating_status')->nullable()->default(0);
            $table->integer('is_report_gen')->nullable()->default(0);
            $table->timestamp('report_gen_time')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
