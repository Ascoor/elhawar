<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class lettersOfGuaranteeTypes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('letters_of_guarantee_types')){

                Schema::create('letters_of_guarantee_types',function (Blueprint $table)
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
        Schema::drop('letters_of_guarantee_types');
        Schema::enableForeignKeyConstraints();
    }

}
