<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveCompanyIdColumnSmtpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('smtp_settings', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id']);
        });

        $smtp = new \App\SmtpSetting();
        $smtp->mail_driver = 'smtp';
        $smtp->mail_host = 'smtp.yandex.com';
        $smtp->mail_port = '465';
        $smtp->mail_username = 'info@codagetech.com';
        $smtp->mail_password = 'yryt435612!^';
        $smtp->mail_from_name = 'info@codagetech.com';
        $smtp->mail_encryption = 'ssl';
        $smtp->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
