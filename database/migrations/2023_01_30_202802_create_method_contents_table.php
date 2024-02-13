<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('method_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('method_id')->length(10)->unsigned();
            $table->string('name')->nullable();
            $table->longText('details')->nullable();
            $table->integer('language_id')->length(10)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('method_contents');
    }
}
