<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DailyRecords extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('daily_records')){

                Schema::create('daily_records',function (Blueprint $table)
                {
                    $table->id();
                    $table->integer('recordIdentifier');
                    $table->enum('type', ['EXPEN', 'REVEN']);
                    $table->date('date');
                    $table->text('description')->nullable();
                    $table->tinyInteger('financial_reviewer_assign')->default(0);
                    $table->tinyInteger('financial_accountant_assign')->default(0);
                    $table->tinyInteger('financial_director_assign')->default(0);
                    $table->enum('status',['Pending','Rejected','Accepted'])->default('Pending');
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
        Schema::drop('daily_records');
        Schema::enableForeignKeyConstraints();
    }

}
