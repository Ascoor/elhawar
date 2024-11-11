<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateInoutFilesTBL extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('inout_files',function (Blueprint $table)
            {
                $table->id();
                $table->string('original_name');
                $table->string('name_on_disk')->unique();
                $table->unsignedBigInteger('inout_group_id');
                $table->timestamps();
            } 
            );

            Schema::table('inout_files',function (Blueprint $table)
            {
                $table->foreign('inout_group_id')
                ->references('id')
                ->on('inout_groups')
                ->cascadeOnDelete();
            });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inout_files');
    }

}
