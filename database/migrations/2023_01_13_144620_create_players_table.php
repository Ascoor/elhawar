<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

            Schema::create('players', function (Blueprint $table) {
                $table->id();
                $table->string('player_id');
                $table->string('union_id')->nullable();
                $table->string('name');
                $table->unsignedBigInteger('national_id')->unique();
                $table->unsignedInteger('sports_id')->nullable();
                $table->unsignedInteger('academy_id')->nullable();
                $table->unsignedInteger('team_id')->nullable();
                $table->string('gender');
                $table->string('date_of_birth');
                $table->string('date_status');
                $table->string('age');
                $table->string('city');
                $table->unsignedInteger('country_id');
                $table->string('kind')->nullable();
                $table->string('status_player')->nullable();
                $table->string('club_name')->nullable();
                $table->string('champions_award')->nullable();
                $table->string('address');
                $table->string('mobile');
                $table->string('guardian_mobile')->nullable();
                $table->string('belt')->nullable();
                $table->string('level')->nullable();
                $table->string('stars')->nullable();
                $table->string('weight')->nullable();
                $table->string('height')->nullable();
                $table->text('note')->nullable();
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
        Schema::table('players', function (Blueprint $table) {
            //
        });
    }
}
