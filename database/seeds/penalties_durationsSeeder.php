<?php

use Illuminate\Database\Seeder;

class penalties_durationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            \DB::table('penalties_durations')->insert([
                'durations' => $i,
                
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ]);
        }
    }
}
