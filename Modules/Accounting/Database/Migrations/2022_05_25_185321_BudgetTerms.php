<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class BudgetTerms extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('budget_terms')){

                Schema::create('budget_terms',function (Blueprint $table)
                {
                    $table->id();
                    $table->string('name', 45);
                    $table->enum('type', ['EXPEN', 'REVEN']);
                    $table->timestamps();
                    //making sure name of terms of the same type is unique
                    $table->unique(['type','name']);
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
        Schema::drop('budget_terms');
        Schema::enableForeignKeyConstraints();
    }

}
