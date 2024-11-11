<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('l1');
            $table->string('l1_name');
            $table->string('l2');
            $table->string('l2_name');
            $table->string('l3');
            $table->string('l3_name');
            $table->string('l4');
            $table->string('l4_name');
            $table->string('l5');
            $table->string('l5_name');
            $table->unsignedInteger('cred')->default(0);
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
        Schema::dropIfExists('revenues_settings');
    }
}
