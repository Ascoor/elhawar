<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AccountingRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('roles')->insert([
            [
                'name' => 'accountant',
                'display_name' => 'Accountant',
                'company_id'=>'1',
                'description'=>'',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'financialReviewer',
                'display_name' => 'Financial Reviewer',
                'company_id'=>'1',
                'description'=>'',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'financialAccountant',
                'display_name' => 'Financial Accountant',
                'company_id'=>'1',
                'description'=>'',
                'created_at' => now(),
                'updated_at' => now(),
            ],            
            [
                'name' => 'financialDirector',
                'display_name' => 'Financial Director',
                'company_id'=>'1',
                'description'=>'',
                'created_at' => now(),
                'updated_at' => now(),
            ],            

        ]);
    }
}
