<?php

use Illuminate\Database\Seeder;
use App\GlobalCurrency;

class GlobalCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $currency = new GlobalCurrency();
        $currency->currency_name = 'Egyptian Pound';
        $currency->currency_symbol = 'LE';
        $currency->currency_code = 'EGP';
        $currency->save();

        $currency = new GlobalCurrency();
        $currency->currency_name = 'Dollars';
        $currency->currency_symbol = '$';
        $currency->currency_code = 'USD';
        $currency->save();

        $currency = new GlobalCurrency();
        $currency->currency_name = 'Pounds';
        $currency->currency_symbol = '£';
        $currency->currency_code = 'GBP';
        $currency->save();

        $currency = new GlobalCurrency();
        $currency->currency_name = 'Euros';
        $currency->currency_symbol = '€';
        $currency->currency_code = 'EUR';
        $currency->currency_position = 'behind';
        $currency->save();

    }

}
