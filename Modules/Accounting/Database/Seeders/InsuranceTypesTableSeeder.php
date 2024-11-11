<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class InsuranceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('insurance_types')->insert([
            [
                'name_ar' => 'ابتدائي',
                'name_en' => 'Primary',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'نهائي',
                'name_en' => 'Final',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
