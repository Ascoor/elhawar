<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('price');
            $table->integer('item_in_stock')->default(1)->unsigned();
            $table->boolean('allow_purchase');
            $table->integer('tax_id')
                ->nullable()
                ->unsigned();
             $table->date('expiration_date')->nullable();
            $table->integer('category_id')->unsigned();
            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                $table->foreign('category_id')
                ->references('id')
                ->on('product_category')
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
        Schema::dropIfExists('products');
    }
}
