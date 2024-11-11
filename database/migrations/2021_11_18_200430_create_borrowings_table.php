<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->nullable();
            $table->unsignedInteger('project_id')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->unsignedInteger('client_id')->nullable();
            $table->unsignedInteger('borrower');
            $table->unsignedInteger('resources');
            $table->unsignedInteger('borrowed')->default(1);
            $table->unsignedInteger('turn_in')->default(0);
            $table->date('borrow_date')->nullable();
            $table->date('due_date');
             
            $table->unsignedInteger('created_by')->nullable(); 
            $table->unsignedInteger('approved')->default(0);
            $table->unsignedInteger('approved_by')->nullable();
            
           
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('borrower')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('resources')->references('id')->on('resources')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('borrowings');
    }
}
