<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 75);
            $table->text('description');
            $table->string('image_url')->nullable();
            $table->longText('content')->nullable();
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
        Schema::dropIfExists('report_formats');
    }
}
