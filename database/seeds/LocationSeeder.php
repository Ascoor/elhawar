<?php

use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('locations')->insert([
            [
                'name' => 'football east',
                'capacity'=>'20',
                'description'=>'football playground',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'football west',
                'capacity'=>'30',
                'description'=>'football playground',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'basketball east',
                'capacity'=>'50',
                'description'=>'basketball playground',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'basketball west',
                'capacity'=>'40',
                'description'=>'basketball playground',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
