<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TeamsTrainings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->bigInteger('sport_id');
            $table->bigInteger('team_id');
            $table->bigInteger('location_id');
            $table->string('label_color');
            $table->string('repeat');
            $table->string('repeat_type');
            $table->integer('repeat_every');
            $table->integer('repeat_cycles');
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
        Schema::dropIfExists('teams_trainings');
    }
}
