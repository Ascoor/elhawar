<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('inventories')->insert([
            [  'id' => '1',  'name' => "Main Branch", 'description' => 'Main Branch', 'location'=> 'Cairo'],
            [  'id '=> '2',  'name' => "Branch 2", 'description' => 'Second Branch', 'location'=> 'Tanta'],
            [  'id' => '3', 'name' => "Branch 3", 'description' => 'Third Branch', 'location'=> 'Mansoura'],
        ]);
    }
}
