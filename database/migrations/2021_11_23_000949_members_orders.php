<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MembersOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->string('name');
            $table->longText('description');
            $table->unsignedInteger('directed_to')->nullable();
            $table->string('file')->nullable();
            $table->unsignedInteger('comments')->default(0);
            $table->unsignedInteger('state')->default(0);
            $table->unsignedInteger('ups')->default(0);
            $table->unsignedInteger('downs')->default(0);
            $table->date('date');
            $table->date('due_date');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('directed_to')->references('id')->on('teams')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
//
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members_orders');
    }

}
