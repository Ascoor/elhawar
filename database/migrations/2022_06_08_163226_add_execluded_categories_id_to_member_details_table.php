<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExecludedCategoriesIdToMemberDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_details', function (Blueprint $table) {
            $table->integer('excluded_categories_id')->unsigned()->nullable()->default(null);
            $table->foreign('excluded_categories_id')->references('id')->on('excluded_categories')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('member_details', function (Blueprint $table) {
            //
        });
    }
}
