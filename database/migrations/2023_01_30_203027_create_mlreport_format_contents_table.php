<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlreportFormatContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlreport_format_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('report_format_id')->length(10)->unsigned();
            $table->string('report_title')->nullable();
            $table->text('report_desc')->nullable();
            $table->longText('report_content')->nullable();
            $table->string('report_image')->nullable();
            $table->integer('language_id')->length(10)->unsigned();
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
        Schema::dropIfExists('mlreport_format_contents');
    }
}
