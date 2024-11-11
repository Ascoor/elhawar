<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFawryToPaymentGatewayCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->string('sandbox_merchant_code')->nullable();
            $table->string('sandbox_merchant_hash')->nullable();
            $table->string('sandbox_plugin_url')->default('https://atfawry.fawrystaging.com')->nullable();

            $table->string('live_merchant_code')->nullable();
            $table->string('live_merchant_hash')->nullable();
            $table->string('live_plugin_url')->default('https://www.atfawry.com')->nullable();

            $table->string('fawry_callback_url')->default('api/fawry-payment-callback')->nullable();

            $table->enum('fawry_mode', ['sandbox', 'live'])->default('sandbox');
            $table->enum('fawry_status', ['active', 'inactive'])->default('active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_gateway_credentials', function (Blueprint $table) {
            $table->dropColumn('sandbox_merchant_code');
            $table->dropColumn('sandbox_merchant_hash');
            $table->dropColumn('sandbox_plugin_url');
            $table->dropColumn('live_merchant_code');
            $table->dropColumn('live_merchant_hash');
            $table->dropColumn('live_plugin_url');
            $table->dropColumn('fawry_callback_url');
            $table->dropColumn('fawry_mode');
            $table->dropColumn('fawry_status');
        });
    }
}
