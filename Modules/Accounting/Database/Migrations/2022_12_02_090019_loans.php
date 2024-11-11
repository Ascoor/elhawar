<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Loans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('loans')){

            Schema::create('loans',function (Blueprint $table)
            {
                $table->id();
                $table->string('borrower', 120);
                $table->decimal('amount', 10, 2); 
                $table->text('description')->nullable(); 
                $table->date('issuingDate');
                $table->date('expirationDate');
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
        Schema::drop('loans');
        Schema::enableForeignKeyConstraints();
    }
}
