<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('request_types')->insert([
            [  'id'=> 1,  'name' => "withdraw",],
            [  'id'=> 2,  'name' => "consumed",],
            [  'id'=> 3,  'name' => "retrieved",],
            [  'id'=> 4,  'name' => "old",],
            [  'id'=> 5,  'name' => "damaged",],
            [  'id'=> 6,  'name' => "scraped",]
        ]);
    }
}
