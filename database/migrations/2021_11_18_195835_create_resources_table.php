<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) { 
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->unsignedInteger('item_in_stock')->default(1);
            $table->unsignedInteger('borrowed')->default(0);
            $table->unsignedInteger('borrowable')->default(1);
            $table->string('file');
            $table->unsignedInteger('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
