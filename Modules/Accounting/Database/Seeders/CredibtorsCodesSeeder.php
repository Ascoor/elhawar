<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CredibtorsCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('codes')->insert([
            [
                'name' => 'الأرصدة',
                'code' => '01',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'الأصول',
                'code' => '02',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'خطابات ضمان',
                'code' => '03',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'مبالغ مدفوعة مقدماً',
                'code' => '04',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تأمينات لدى الغير',
                'code' => '05',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ارصدة مدنية- حماية النيل',
                'code' => '06',
                'type' => 'CREDIBTOR',
                'is_main' => '0',
                'level' =>1,
                'in_level_identifier' =>6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'طابع الشهيد',
                'code' => '07',
                'type' => 'CREDIBTOR',
                'is_main' => '0',
                'level' =>1,
                'in_level_identifier' =>7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تأمينات نهائية',
                'code' => '14',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'ضمان أعمال',
                'code' => '15',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'تأمينات مقابل خطاب ضمان',
                'code' => '16',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'أمانات للغير',
                'code' => '17',
                'type' => 'CREDIBTOR',
                'is_main' => '1',
                'level' =>1,
                'in_level_identifier' =>17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'المحاسب القانوني',
                'code' => '18',
                'type' => 'CREDIBTOR',
                'is_main' => '0',
                'level' =>1,
                'in_level_identifier' =>18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
