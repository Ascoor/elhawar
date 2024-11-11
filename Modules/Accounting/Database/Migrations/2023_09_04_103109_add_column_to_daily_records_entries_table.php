<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDailyRecordsEntriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('daily_records_entries', function (Blueprint $table) {
        //     $table->unsignedBigInteger('user_id');

        //     $table->foreign('user_id')
        //     ->references('id')
        //     ->on('users')
        //     ->restrictOnUpdate()
        //     ->cascadeOnDelete();

            
        // });


        // Schema::table('packages', function (Blueprint $table) {
        //     $table->boolean('is_private');
        // });
        // Schema::table('packages', function (Blueprint $table) {
        //     $table->dropColumn(['is_private']);
        // });


        // Schema::table('daily_records_entries',function (Blueprint $table)
        // {

        //         // $table->foreign('user_id')
        //         // ->references('id')
        //         // ->on('users')
        //         // ->restrictOnUpdate()
        //         // ->cascadeOnDelete();
                
              
        // });
    }

   

       
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::disableForeignKeyConstraints();
        Schema::drop('daily_records_entries');
        Schema::enableForeignKeyConstraints();
        // OR 
        // Schema::table('daily_records_entries', function(Blueprint $table)
//         {
//             $table->dropForeign('daily_records_entries_user_id_foreign');
//             $table->dropColumn(['user_id']);
// // $table->dropColumn('user_id');

//         });
    }

}
