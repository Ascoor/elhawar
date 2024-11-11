<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddCashedToChecksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checks', function(Blueprint $table)
        {
            $table->enum('cashed',[0,1])->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('checks', 'cashed'))
        {
            Schema::table('checks', function (Blueprint $table)
            {
                $table->dropColumn('cashed');
            });
        }

    }

}