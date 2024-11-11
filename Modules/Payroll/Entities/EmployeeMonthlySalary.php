<?php

namespace Modules\Payroll\Entities;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payroll\Observers\EmployeeMonthlySalaryObserver;

class EmployeeMonthlySalary extends Model
{
    protected $guarded = ['id'];

    protected $dates = ['date'];

    protected static function boot()
    {
        parent::boot();

        static::observe(EmployeeMonthlySalaryObserver::class);

        static::addGlobalScope(new CompanyScope);
    }


    public static function employeeNetSalary($userId, $tillDate = null)
    {
        $initialSalary = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'initial')->sum('amount');
//        if (!is_null($tillDate)) {
//            $addSalary = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'increment')->where('date', '<=', $tillDate)->sum('amount');
//        }else{
            $addSalary = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'increment')->sum('amount');
//        }
//        if (!is_null($tillDate)) {
//            $allowances = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'allowances')->where('date', '<=', $tillDate)->sum('amount');
//        }else{
            $allowances = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'allowances')->sum('amount');
//        }
//        if (!is_null($tillDate)) {
//            $subtractSalary = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'decrement')->where('date', '<=', $tillDate)->sum('amount');
//        }else{
            $subtractSalary = EmployeeMonthlySalary::where('user_id', $userId)->where('type', 'decrement')->sum('amount');
//        }
        $netSalary = $initialSalary + $allowances+ $addSalary - $subtractSalary;
        if ($netSalary < 0) {
            $netSalary = 0;
        }
        return [
            'allowances' => $allowances,
            'addSalary' => $addSalary,
            'initialSalary' => $initialSalary,
            'netSalary' => $netSalary,
        ];
    }
    public static function employeeIncrements($userId)
    {
        return EmployeeMonthlySalary::where('user_id', $userId)
            ->where('type', '=', 'increment')
            ->get();
    }
    public static function employeeAllowances($userId)
    {
        return EmployeeMonthlySalary::where('user_id', $userId)
            ->where('type', '=', 'allowances')
            ->get();
    }
}
