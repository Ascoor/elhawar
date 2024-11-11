<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UpdateChecksTable extends Migration
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
            $table->addColumn('bigInteger','code_id')->unsigned()->nullable()->default(null);
        });

        Schema::table('checks',function (Blueprint $table)
        {
            $table->foreign('code_id')
            ->references('id')
            ->on('codes')
            ->restrictOnUpdate()
            ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checks', function(Blueprint $table)
        {
            Schema::disableForeignKeyConstraints();
            $table->dropColumn('code_id');
            Schema::enableForeignKeyConstraints();
        });
    }

}
