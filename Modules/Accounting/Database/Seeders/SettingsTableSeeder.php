<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('accounting_settings')->insert(['capital'=>0]);
    }

}