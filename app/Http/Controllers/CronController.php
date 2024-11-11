<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CronController extends Controller
{
    public function testCron()
    {
        $expiration_date = \DateTime::createFromFormat('Y-m-d', '2020-06-12');
        $today = new \DateTime();

        if ($expiration_date->format('n') === $today->format('n') && $expiration_date->format('Y') === $today->format('Y')) {
            return "Months match and year match";
        }

        return "not match";
    }
}