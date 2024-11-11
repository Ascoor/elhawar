<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankAccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bank_account_types')->insert([
            [
                'name_ar' => 'جارى',
                'name_en' => 'Current',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'توفير',
                'name_en' => 'Saving',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'أعمال',
                'name_en' => 'Business',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'وديعة توفير',
                'name_en' => 'Savings Deposit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name_ar' => 'وديعة لأجل',
                'name_en' => 'Term Deposit',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}

