<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BankTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('bank_transfers')){

            Schema::create('bank_transfers',function (Blueprint $table)
            {
                $table->id();
                $table->unsignedBigInteger('bank_account_type_id');
                $table->string('number', 120)->unique();
                $table->date('date');
                $table->string('bankName', 120);
                $table->string('recipient', 120);
                $table->decimal('amount', 10, 2); 
                $table->enum('status',['in','out']); 
                $table->timestamps();
            } 
            
            );

            Schema::table('bank_transfers',function (Blueprint $table)
            {
                    $table->foreign('bank_account_type_id')
                    ->references('id')
                    ->on('bank_account_types')
                    ->restrictOnUpdate()
                    ->restrictOnDelete();
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
        Schema::drop('bank_transfers');
        Schema::enableForeignKeyConstraints();
    }
}
