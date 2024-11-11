<?php 
namespace App\Helper;

use Illuminate\Support\Facades\App;

class Arabic
{
    static function arNums($expression,$isMoney=false) 
    {
        if($isMoney)
        {
            $expression=number_format($expression,2);
        }
        if(App::isLocale('ar'))
        {
            return str_replace(range(0,9), ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'], $expression);
        }
        else
        {
            return $expression;
        }
    }
}
