<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SportLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sport_location', function (Blueprint $table) {
            $table->id();
            $table->string('session_name');
            $table->string('session_id');
            $table->string('label_color');
            $table->string('repeat');
            $table->string('repeat_type');
            $table->integer('repeat_every');
            $table->integer('repeat_cycles');
            $table->string('reservation_type');
            $table->bigInteger('location_id');
            $table->bigInteger('sport_id');
            $table->bigInteger('level_id');
            $table->bigInteger('group_id');
            $table->bigInteger('coach_id');
            $table->integer('capacity');
            $table->integer('available');
            $table->integer('waiting');
            $table->double('fees');
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
        Schema::dropIfExists('sport_location');
    }
}
