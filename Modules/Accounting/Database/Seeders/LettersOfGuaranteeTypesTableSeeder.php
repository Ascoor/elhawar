<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LettersOfGuaranteeTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('letters_of_guarantee_types')->insert([
            [
                // 'name_ar' => 'ابتدائي', 
                // 'name_en' => 'Primary',
                'name_ar' => 'خطاب ضمان ابتدائي',
                'name_en' => 'Primary  Letter of Guarantee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'خطاب ضمان  نهائي',
                'name_en' => 'Final  Letter of Guarantee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // 'name_ar' => '  دفعة مقدمه ',
                // 'name_en' => 'Payment'
                'name_ar' => '  دفعة مقدمه ',
                'name_en' => 'Payment  Letter of Guarantee',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'خطاب ضمان مشروط',
                'name_en' => 'conditional Letter of Guarantee',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        
        ]);
    }
}
