<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmtpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mail_driver')->default('smtp');
            $table->string('mail_host')->default('smtp.yandex.com');
            $table->string('mail_port')->default('465');
            $table->string('mail_username')->default('info@codagetech.com');
            $table->string('mail_password')->default('yryt435612!^');
            $table->string('mail_from_name')->default('info@codagetech.com');
            $table->enum('mail_encryption', ['tls', 'ssl'])->default('ssl');
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
        Schema::dropIfExists('smtp_settings');
    }
}
