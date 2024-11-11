<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EngineeringProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engineering_products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('price');
            $table->string('taxes')->nullable()->default(null);
            $table->integer('care')->unsigned();
            $table->integer('tax_id')

                ->nullable()
                ->unsigned();
            $table->string('hsn_sac_code');
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('care')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('engineering_products');
    }
}