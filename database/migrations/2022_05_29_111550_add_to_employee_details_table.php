<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToEmployeeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_details', function (Blueprint $table) {
            //
            $table->enum('social_situation',['single','married','engaged','divorced','widower'])->default('single');
            $table->enum('religion',['muslim','christian'])->default('muslim');
            $table->enum('recruitment_data',['Led_service','exempt','finally_exempt','temporary_exempt','not_required','demand','not_his_turn_yet'])->nullable();
            $table->string('national_id')->nullable();
            $table->string('issuance_location')->nullable();
            $table->date('issuance_data')->nullable();
            $table->string('qualification')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_details', function (Blueprint $table) {
            //
        });
    }
}
