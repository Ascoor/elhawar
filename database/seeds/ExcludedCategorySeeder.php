<?php

use Illuminate\Database\Seeder;

class ExcludedCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('excluded_categories')->insert([
            [
                'name' => 'normal',
            ],
            [
                'name' => 'police',
            ],
            [
                'name' => 'judges',
            ],
            [
                'name' => 'journalists',
            ],
            [
                'name' => 'warrior_forces',
            ],
            [
                'name' => 'sports_affairs',
            ],
            [
                'name' => 'armed_forces',
            ],
            [
                'name' => 'people_with_needs',
            ],

        ]);
    }
}
