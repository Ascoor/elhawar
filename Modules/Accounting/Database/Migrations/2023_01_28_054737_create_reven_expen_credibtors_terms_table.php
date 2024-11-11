<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateRevenExpenCredibtorsTermsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reven_expen_credibtors_terms', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('code_id')->unique();
            $table->timestamps();
        });
        Schema::table('reven_expen_credibtors_terms',function (Blueprint $table)
        {
                $table->foreign('code_id')
                ->references('id')
                ->on('codes')
                ->restrictOnUpdate()
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
        Schema::disableForeignKeyConstraints();
        Schema::drop('reven_expen_credibtors_terms');
        Schema::enableForeignKeyConstraints();
    }

}
