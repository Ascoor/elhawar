<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Codes extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        if(!Schema::hasTable('codes')){

                Schema::create('codes',function (Blueprint $table)
                {
                    $table->id();
                    $table->unsignedBigInteger('code_id')->nullable()->default(null);
                    $table->string('name', 45);
                    $table->string('code', 10);
                    $table->enum('type', ['EXPEN', 'REVEN','ACC','CREDIBTOR']);
                    $table->unsignedTinyInteger('level');
                    $table->unsignedTinyInteger('in_level_identifier');
                    $table->enum('is_main', ['0','1']);
                    $table->timestamps();
                    //making sure codes of the same type are unique
                    $table->unique(['type','code']);
                    //making sure name of codes of the same node are unique
                    $table->unique(['code_id','name','type']);

                } 
                
                );

                Schema::table('codes',function (Blueprint $table)
                {
                    $table->foreign('code_id')
                    ->references('id')
                    ->on('codes')
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
        Schema::drop('codes');
        Schema::enableForeignKeyConstraints();
    }

}
