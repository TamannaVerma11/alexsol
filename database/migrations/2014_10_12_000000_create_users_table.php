<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->string('profile_img')->nullable();
            $table->enum('user_type', ['user', 'consultant', 'company_owner', 'admin_super', 'admin_support'])->nullable()->default('user');
            $table->string('password');
            $table->string('phone', 30)->unique();
            $table->tinyInteger('approve_per')->nullable()->default(0);
            $table->tinyInteger('tfa_status')->nullable()->default(0);
            $table->string('tfa_type', 10)->nullable();
            $table->string('tfa_email')->nullable();
            $table->string('tfa_phone', 30)->nullable();
            $table->text('pin_code')->nullable();
            $table->string('google_auth_code', 500)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->integer('company_id')->length(10)->unsigned()->nullable();
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
        Schema::dropIfExists('users');
    }
}
