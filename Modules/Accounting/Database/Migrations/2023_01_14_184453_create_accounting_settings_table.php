<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAccountingSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_settings', function(Blueprint $table)
        {
            $table->id();
            $table->decimal('capital')->default(0);
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
        if(Schema::hasTable('accounting_settings'))
        {
            Schema::disableForeignKeyConstraints();
            Schema::drop('accounting_settings');
            Schema::enableForeignKeyConstraints();    
        }
    }

}
