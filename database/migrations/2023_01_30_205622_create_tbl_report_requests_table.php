<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblReportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_report_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permisson_ticket_title', 50)->nullable();
            $table->integer('ticket_id')->length(10)->unsigned()->nullable();
            $table->integer('user_id')->length(10)->unsigned()->nullable();
            $table->integer('company_id')->length(10)->unsigned()->nullable();
            $table->integer('consultancy_id')->length(10)->unsigned()->nullable()->default(0);
            $table->integer('report_id')->length(10)->unsigned()->nullable();
            $table->enum('status', ['0', '1', '2'])->nullable()->default('0');
            $table->enum('permission_by', ['0', '1'])->nullable();
            $table->date('request_date_time')->nullable();
            $table->date('approval_date_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_report_requests');
    }
}
