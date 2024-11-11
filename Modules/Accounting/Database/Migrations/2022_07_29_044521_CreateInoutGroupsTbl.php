<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateInoutGroupsTBL extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('inout_groups',function (Blueprint $table)
            {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable()->default(null);
                $table->enum('type', ['IN', 'OUT']);
                $table->timestamps();
            } 
            );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inout_groups');
    }

}
