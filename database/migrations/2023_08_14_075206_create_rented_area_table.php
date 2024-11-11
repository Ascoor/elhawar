<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentedAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rented_area', function (Blueprint $table) {
            $table->id();
            // get hourly * price = total price
            // $table->string('total_price');
            // $table->dateTime('start_time')->format('DD-MM-YYYY hh:mm:ss');
            // $table->dateTime('end_time')->format('DD-MM-YYYY hh:mm:ss');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
            $table->string('client_name');
            $table->string('phone_number');
            $table->integer('price');
            

            // $table->unsignedInteger('area_rent_details_id')->unsigned();
            // $table->foreign(area_rent_details_id')->references('id')->on('area_rent_details');
            // ->onDelete('cascade')
            // $table->dateTime('occasion_date')->format('DD-MM-YYYY hh:mm:ss');
            $table->unsignedBigInteger('area_rent_details_id');
            $table->foreign('area_rent_details_id')->references('id')->on('area_rent_details');
            // $table->unsignedInteger('from');
            // $table->foreign('from')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('guardian', ['yes', 'no'])->default('no');
            $table->integer('employee_details_id')->unsigned()->nullable();
            $table->foreign('employee_details_id')->references('id')->on('employee_details');
            // $table->date('start_date')->format('DD-MM-YYYY');
            // $table->date('end_date')->format('DD-MM-YYYY');
            $table->enum('session_repeat', ['yes', 'no'])->default('no');

            $table->string('label_color');
            $table->enum('repeat_type', ['day','week','month','year'])->nullable();
            // $table->string('repeat_type')->nullable(); //day,month,year,
            $table->integer('repeat_every')->nullable();
            $table->integer('repeat_cycles')->nullable();
         
            $table->enum('status', ['generated', 'canceled', 'started'])->default('generated');
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
        Schema::dropIfExists('rented_area');
    }
}
