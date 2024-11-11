<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColDelegationInsuranceToEmployeeDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_details', function (Blueprint $table) {
            $table->unsignedInteger('insuranceStatus')->default(0);
            $table->unsignedInteger('delegation')->nullable();
            $table->string('delegationInstitution')->nullable();
            $table->string('insuranceNumber')->nullable();
            $table->string('insuranceStartDate')->nullable();

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
