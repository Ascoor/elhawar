<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DailyRecordsEntries extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('daily_records_entries')){

                Schema::create('daily_records_entries',function (Blueprint $table)
                {
                    $table->id();
                    $table->unsignedBigInteger('code_id');
                    $table->unsignedBigInteger('user_id');

                   
                    $table->unsignedBigInteger('daily_record_id');
                    $table->decimal('amount', 10, 2); 
                    $table->enum('type', ['DEBIT', 'CREDIT']);
                    $table->date('payment_date');
                    $table->timestamps();
                });

                
                Schema::table('daily_records_entries', function (Blueprint $table) {
                    $table->foreign('code_id')
                          ->references('id')
                          ->on('codes')
                          ->restrictOnUpdate()
                          ->cascadeOnDelete();
                    $table->foreign('daily_record_id')
                          ->references('id')
                          ->on('daily_records')
                          ->cascadeOnDelete();
                    $table->foreign('user_id')
                          ->references('id')
                          ->on('users')
                          ->restrictOnUpdate()
                          ->cascadeOnDelete();
                });
                

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
        Schema::drop('daily_records_entries');
        Schema::enableForeignKeyConstraints();
    }

}
