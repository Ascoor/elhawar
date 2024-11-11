<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;

class AssetsDepreciations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('assets_deprecations')){

            Schema::create('assets_deprecations',function (Blueprint $table)
            {
                $table->id();
                $table->unsignedBigInteger('code_id')->unique();
                $table->double('numberOfYears')->default(0.0);
                $table->double('precentageOfDeprecation')->default(0.0);
                $table->timestamps();
            });

            Schema::table('assets_deprecations',function (Blueprint $table)
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
        Schema::drop('assets_deprecations');
        Schema::enableForeignKeyConstraints();
    }

}
