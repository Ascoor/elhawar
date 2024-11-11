<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LettersOfGuarantee extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('letters_of_guarantee')){

            Schema::create('letters_of_guarantee',function (Blueprint $table)
            {
                $table->id();
                $table->string('issuedToCompany', 120);
                $table->string('issuingBank', 120);
                $table->string('letterNumber', 120)->unique();
                $table->unsignedBigInteger('letterType');
                $table->decimal('amount', 10, 2); 
                $table->text('description')->nullable(); 
                $table->date('issuingDate');
                $table->date('expirationDate');
                $table->timestamps();
            } 
            
            );

            Schema::table('letters_of_guarantee',function (Blueprint $table)
            {

                    $table->foreign('letterType')
                    ->references('id')
                    ->on('letters_of_guarantee_types')
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
        Schema::drop('letters_of_guarantee');
        Schema::enableForeignKeyConstraints();
    }
}
