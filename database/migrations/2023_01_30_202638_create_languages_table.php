<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('language_code');
            $table->string('date_format')->nullable()->default('Y:m:d H:i:s');
            $table->tinyInteger('active')->nullable()->default(1);
            $table->tinyInteger('lang_default')->nullable()->default(0);
            $table->tinyInteger('is_rtl')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
