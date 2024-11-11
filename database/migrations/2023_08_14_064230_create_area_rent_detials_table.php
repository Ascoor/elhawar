<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;


use Illuminate\Support\Facades\Schema;

class CreateAreaRentDetialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_rent_details', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->integer('area_capacity');
            $table->text('description')->nullable();
            // $table->enum('guardian', ['yes', 'no'])->default('no');
            // $table->integer('price');

            // hourly price 
            //price = price * hour 
            // $table->integer('currency');
            $table->text('location');
            // $table->integer('employee_details_id')->unsigned()->nullable();



            
            // $table->unsigned('employee_details_id')->nullable();
          
            // $table->foreign('from')->references('id')->on('users')
            // ->unsigned()
            // $table->foreign('employee_details_id')->references('id')->on('employee_details');
            // ->onDelete('SET NULL')->onUpdate('cascade');
           

           

           
           

            
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
        Schema::dropIfExists('area_rent_details');
    }
}


