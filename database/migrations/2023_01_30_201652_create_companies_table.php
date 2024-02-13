<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('upload_company_img')->nullable();
            $table->tinyInteger('as_consultant')->nullable()->default(0);
            $table->tinyInteger('assigned')->nullable()->default(0);
            $table->integer('size')->nullable()->length(10)->unsigned()->default(0);
            $table->integer('package_id')->nullable()->length(10)->unsigned()->nullable();
            $table->integer('industry_type')->length(10)->unsigned()->nullable();
            $table->tinyInteger('remainder_sent')->nullable()->length(1)->default(0);
            $table->integer('payment_cycle')->nullable()->length(10)->unsigned()->default(3);
            $table->date('expire')->nullable();
            $table->string('status', 30)->nullable()->default('pending');
            $table->tinyInteger('show_tickets')->nullable()->length(1)->default(1);
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
        Schema::dropIfExists('companies');
    }
}
