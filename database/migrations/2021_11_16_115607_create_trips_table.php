<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('trip_name');
            $table->string('label_color');
            $table->string('repeat');
            $table->string('repeat_type');
            $table->integer('repeat_every');
            $table->integer('repeat_cycles');
            $table->unsignedBigInteger('supervisor_id');
            $table->text('program');
            $table->string('image');
            $table->integer('capacity');
            $table->integer('available');
            $table->double('member_fees');
            $table->double('non_member_fees');
            $table->double('escort_fees');
            $table->string('currency');
            $table->dateTime('start_date_time');
            $table->dateTime('end_date_time');
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
        Schema::dropIfExists('trips');
    }
}
