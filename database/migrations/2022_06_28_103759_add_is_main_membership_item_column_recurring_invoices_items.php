<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsMainMembershipItemColumnRecurringInvoicesItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


         Schema::table('invoice_recurring_items', function (Blueprint $table) {
             $table->tinyInteger('is_main_membership_item')->default(0);
         });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_recurring_items', function (Blueprint $table) {
            //
        });
    }
}
