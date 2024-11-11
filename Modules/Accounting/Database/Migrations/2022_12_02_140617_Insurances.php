<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Insurances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('insurances')){

            Schema::create('insurances',function (Blueprint $table)
            {
                $table->id();
                $table->unsignedBigInteger('insurance_type_id');
                $table->decimal('amount', 10, 2); 
                $table->date('paymentDate');
                $table->date('returnDate');
                $table->text('purpose')->nullable(); 
                $table->timestamps();
            } 
            
            );

            Schema::table('insurances',function (Blueprint $table)
            {
                    $table->foreign('insurance_type_id')
                    ->references('id')
                    ->on('insurance_types')
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
        Schema::drop('insurances');
        Schema::enableForeignKeyConstraints();
    }
}
