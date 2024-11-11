<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrdersComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('comment');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('comment_by');
            $table->timestamps();
            $table->foreign('order_id')->references('id')->on('members_orders')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('comment_by')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_comments');
    }

}
