<?php

use Illuminate\Database\Seeder;

class penalty_daysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            \DB::table('penalty_days')->insert([
                'days' => $i,
                
                // 'created_at' => now(),
                // 'updated_at' => now(),
            ]);
        };

    }
}
