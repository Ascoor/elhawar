<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class TermItems extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('term_items')){

                Schema::create('term_items',function (Blueprint $table)
                {
                    $table->id();
                    $table->unsignedBigInteger('code_id');
                    $table->unsignedBigInteger('budget_term_id');
                    $table->timestamps();
                    $table->unique(['code_id']);
                });

                

                Schema::table('term_items',function (Blueprint $table)
                {

                        $table->foreign('code_id')
                        ->references('id')
                        ->on('codes')
                        ->restrictOnUpdate()
                        ->cascadeOnDelete();
                        
                        $table->foreign('budget_term_id')
                        ->references('id')
                        ->on('budget_terms')
                        ->cascadeOnDelete();   
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
        Schema::drop('term_items');
        Schema::enableForeignKeyConstraints();
    }

}
