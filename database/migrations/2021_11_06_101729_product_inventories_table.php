<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_inventories', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('product')->unsigned();
             $table->integer('inventory')->unsigned();
             $table->integer('price');
             $table->unsignedInteger('item_in_stock');
             $table->unsignedInteger('consumed');
             $table->unsignedInteger('old');
             $table->unsignedInteger('damaged');
             $table->unsignedInteger('scraped');
             $table->foreign('product')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
             $table->foreign('inventory')->references('id')->on('inventories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('product_inventories');
    }
}
