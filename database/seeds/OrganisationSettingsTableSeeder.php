<?php

use Illuminate\Database\Seeder;
use App\Setting;
use App\Currency;


class OrganisationSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $currency = Currency::where('currency_code', 'EGP')->first();

        $setting = new Setting();
        $setting->company_name = 'Elhawar Sports Club';
        $setting->company_email = 'company@email.com';
        $setting->company_phone = '1234567891';
        $setting->address = 'Company address';
        $setting->website = 'www.elhawar.com';
        $setting->currency_id = $currency->id;
        $setting->timezone = 'Africa/Cairo';
        $setting->rounded_theme = 1;
        $setting->save();
    }

}
