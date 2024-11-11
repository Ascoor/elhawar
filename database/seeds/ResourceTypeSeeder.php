<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('resource_types')->insert([
            [  'id' => '1',  'name' => "book",],
            [  'id '=> '2',  'name' => "audio",],
            [   'id' => '3', 'name' => "video",],
        ]);
    }
}
