<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class InsuranceTypes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('insurance_types')){

                Schema::create('insurance_types',function (Blueprint $table)
                {
                    $table->id();
                    $table->string('name_en', 60);
                    $table->string('name_ar', 60);
                    $table->timestamps();

                } 
                
                );

        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::drop('insurance_types');
        Schema::enableForeignKeyConstraints();
    }

}
