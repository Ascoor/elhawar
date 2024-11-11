<?php

use Illuminate\Database\Seeder;

class PlayerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('player_groups')->insert([
            [
                'name' => 'A1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'B1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'C1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            ]);
    }
}
