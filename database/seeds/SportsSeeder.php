<?php

use Illuminate\Database\Seeder;

class SportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sports')->insert([
            [
                'name' => 'football',
                'code'=>'F-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'basketball',
                'code'=>'B-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'swimming',
                'code'=>'S-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
