<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            [
                'name' => 'high',
                'description'=>'most skilled',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'medium',
                'description'=>'ordinary',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'low',
                'description'=>'beginners',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
