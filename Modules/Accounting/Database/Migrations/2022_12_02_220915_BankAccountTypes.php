<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class BankAccountTypes extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('bank_account_types')){

                Schema::create('bank_account_types',function (Blueprint $table)
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
        Schema::drop('bank_account_types');
        Schema::enableForeignKeyConstraints();
    }

}
