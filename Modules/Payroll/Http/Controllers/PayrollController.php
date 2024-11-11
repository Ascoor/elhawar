<?php

namespace Modules\Payroll\Http\Controllers;

use App\Attendance;
use App\AttendanceSetting;
use App\Designation;
use App\EmployeeDetails;
use App\Expense;
use App\Helper\Reply;
use App\Holiday;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Leave;
use App\ProjectTimeLog;
use App\Team;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Modules\Payroll\Entities\EmployeeMonthlySalary;
use Modules\Payroll\Entities\EmployeeSalaryGroup;
use Modules\Payroll\Entities\PayrollSetting;
use Modules\Payroll\Entities\SalaryPaymentMethod;
use Modules\Payroll\Entities\SalarySlip;
use Modules\Payroll\Entities\SalaryTds;
use Modules\Payroll\Notifications\SalaryStatusEmail;
use phpDocumentor\Reflection\DocBlockFactory;
use Yajra\DataTables\Facades\DataTables;

//rola Penalties
//  use '../';
use App\Penalties;

//rola
//this will display the penalty duration deduction
use App\PenaltiesDurations;

//  include(__DIR__ .'../../../../app/Penalties.php');
//  require __DIR__ . '../../../../app/Penalties.php';


// __DIR__.'/app/Penalties.php';

class PayrollController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('payroll::app.menu.payroll');
        $this->pageIcon = 'icon-wallet';
        $this->middleware(function ($request, $next) {
            if (!in_array('payroll', $this->modules)) {
                abort(403);
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $this->departments = Team::all();
        $this->designations = Designation::all();

        $now = Carbon::now();
        $this->year = $now->format('Y');
        $this->month = $now->format('m');
        $this->salaryPaymentMethods = SalaryPaymentMethod::all();

        return view('payroll::payroll.index', $this->data);
    }
    public function showMonthlyPayrollList($month, $year)
    {
        if ($month > 0 && $year > 0) {
            $content = array();
            $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
                ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
                ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.id', 'users.name', 'users.email', 'users.image', 'designations.name as designation_name', 'salary_slips.net_salary', 'salary_slips.paid_on', 'salary_slips.status as salary_status', 'salary_slips.id as salary_slip_id')
                ->where('roles.name', '<>', 'client')
                ->where('salary_slips.month', $month)
                ->where('salary_slips.year', $year)
                ->groupBy('users.id')
                ->orderBy('users.id', 'asc')
                ->get()
                ->makeHidden('unreadNotifications');
            $ind = 0;
            $tBasic = 0.0;
            $tAllow = 0.0;
            $tTotal = 0.0;
            $tEar1 = 0.0;
            $tAccuir = 0.0;
            $tDed1 = 0.0;
            $tDed2 = 0.0;
            $tTDS = 0.0;
            $tDiffOthers = 0.0;
            $tTdeduc = 0.0;
            $tNet = 0.0;
            $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;
            foreach ($users as $user) {
                $employeeSal = EmployeeMonthlySalary::employeeNetSalary($user->role[0]->user_id);
                $slip = SalarySlip::where('user_id', $user->role[0]->user_id)->where('month', $month)->where('year', $year)->first();
                $content[$ind]['ind'] = $ind;
                $content[$ind]['ind'] = ' ' . ($content[$ind]['ind'] + 1);
                $content[$ind]['name'] = $user->name;
                $content[$ind]['designation'] = $user->designation_name;
                $content[$ind]['NoOfDays'] = ' ' . $slip->pay_days;
                $content[$ind]['effectedBasic'] = round($slip->basic_salary, 2);
                $content[$ind]['Basic'] = round($employeeSal['initialSalary'], 2);
                $tBasic += $content[$ind]['Basic'];
                $alla = $employeeSal['allowances'];
                $content[$ind]['effectedAllowances'] = round($alla * ($slip->pay_days / $daysInMonth), 2);
                $content[$ind]['Allowance'] = round($alla, 2);
                $tAllow += $content[$ind]['Allowance'];
                $content[$ind]['Total'] = $content[$ind]['Allowance'] + $content[$ind]['Basic'];
                $tTotal += $content[$ind]['Total'];
                $salaryJson = json_decode($slip->salary_json, true);
                $earnings = $salaryJson['earnings'];
                $content[$ind]['ear1'] = 0.0;
                $i = 1;
                $content[$ind]['OtherDifferences'] = round($content[$ind]['Basic'] + $content[$ind]['Allowance']);
                if (sizeof($earnings) > 0) {
                    foreach ($earnings as $key => $value) {
                        $content[$ind]['EffectedEar' . $i] = round($value, 1);
                        if ($slip->pay_days == 0) {
                            $content[$ind]['ear' . $i] = round($value * (0), 1);
                        } else {
                            $content[$ind]['ear' . $i] = round($value * ($daysInMonth / $slip->pay_days), 1);
                        }

                        $content[$ind]['OtherDifferences'] += $content[$ind]['ear' . $i] - $content[$ind]['EffectedEar' . $i];
                        $i++;
                    }
                } else {
                    $content[$ind]['ear' . $i] = 0.0;
                }
                $content[$ind]['OtherDifferences'] -= round($content[$ind]['effectedBasic'] + $content[$ind]['effectedAllowances'], 2);
                $tDiffOthers += $content[$ind]['OtherDifferences'];
                $content[$ind]['OtherDifferences'] = ' ' . round($content[$ind]['OtherDifferences'], 0);
                $tEar1 += $content[$ind]['ear1'];
                $content[$ind]['TotalAccruals'] = $content[$ind]['Total'] + $content[$ind]['ear1'];
                $tAccuir += $content[$ind]['TotalAccruals'];
                $deductions = $salaryJson['deductions'];
                $i = 1;
                $content[$ind]['ded1'] = 0.0;
                $content[$ind]['ded2'] = 0.0;
                $content[$ind]['TDS'] = 0.0;
                if (sizeof($deductions) > 0) {
                    foreach ($deductions as $key => $value) {
                        if ($key == 'TDS') {
                            $content[$ind]['TDS'] = round($value, 1);
                        } else {
                            $content[$ind]['ded' . $i] = round($value, 1);
                        }
                        $i++;
                    }
                }
                $tDed1 += $content[$ind]['ded1'];
                $tDed2 += $content[$ind]['ded2'];
                $tTDS += $content[$ind]['TDS'];
                $content[$ind]['TotalDeductions'] = $content[$ind]['TDS'] + $content[$ind]['ded1'] + $content[$ind]['ded2'] + $content[$ind]['OtherDifferences'];
                $tTdeduc += $content[$ind]['TotalDeductions'];
                $content[$ind]['Net'] = $slip->net_salary;
                $tNet += $content[$ind]['Net'];
                $ind++;
            }

            $this->totalBasic = $this->enToAr($tBasic);
            $this->totalAllow = $this->enToAr($tAllow);
            $this->totalTotal = $this->enToAr($tTotal);
            $this->totalEar1 = $this->enToAr($tEar1);
            $this->totalAccuir = $this->enToAr($tAccuir);
            $this->totalDed1 = $this->enToAr($tDed1);
            $this->totalDed2 = $this->enToAr($tDed2);
            $this->totalTDS = $this->enToAr($tTDS);
            $this->totalTdeduc = $this->enToAr($tTdeduc);
            $this->totalNet = $this->enToAr($tNet);
            $this->tDiffOthers = $this->enToAr($tDiffOthers);


            $this->contents = $content;
            $this->arabicTotalAmount = 'فقط' . $this->enToAr($tNet) . ' جنية مصري لاغير ';
            $this->arabicTitle = 'كشف صرف مرتبات الاداريين الغير مؤمن والمؤمن عليهم ' . __('payroll::modules.mon' . $month) . ' ' . $this->enToAr($year);
            //return $content;

            /////////
            $documentFileName = 'allEmployeesSlip.pdf';
            $view = View::make('payroll::payroll.showMonthlyPayrollList', $this->data);
            $html_content = $view->render();

            $pdf = App('TCPDF');
            $pdf->SetFont('aealarabiya', '', 10);

            $pdf->SetTitle('Report');
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(TRUE, 5);
            $pdf->writeHTML($html_content, true, false, true, false, '');
            $pdf->Output($documentFileName);

            ////////////



            //return view('payroll::payroll.showMonthlyPayrollList', $this->data);
        } else {
            $this->departments = Team::all();
            $this->designations = Designation::all();

            $now = Carbon::now();
            $this->year = $now->format('Y');
            $this->month = $now->format('m');
            $this->salaryPaymentMethods = SalaryPaymentMethod::all();

            return view('payroll::payroll.index', $this->data);
        }
    }
    public function showMonthlyPayrollLisInsured($month, $year)
    {

        //rororo



        if ($month > 0 && $year > 0) {
            $content = array();

            //rola
            if ($month == 1) {
                $monthPrev = 12;
                $yearPrev = $year - 1;
            } else {
                $monthPrev = $month - 1;
                $yearPrev = $year;
            }

            // $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;
            $startDate = Carbon::parse(Carbon::parse('01-' . $month . '-' . $year))->startOfMonth();
            $startDatePrev = Carbon::parse(Carbon::parse('01-' . $monthPrev . '-' . $yearPrev))->startOfMonth();
            $endDate = Carbon::parse(Carbon::parse('01-' . $month . '-' . $year))->endOfMonth();
            $endDatePrev = Carbon::parse(Carbon::parse('01-' . $monthPrev . '-' . $yearPrev))->endOfMonth();

            //ORIGINAL
            // $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            // ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            // ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            // ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
            // ->join('roles', 'roles.id', '=', 'role_user.role_id')
            // ->select('users.id', 'users.name', 'users.email', 'users.image', 'designations.name as designation_name', 'salary_slips.net_salary', 'salary_slips.paid_on', 'salary_slips.status as salary_status', 'salary_slips.id as salary_slip_id')
            // ->where('roles.name', '<>', 'client')
            // ->where('sala ry_slips.month', $month)
            // ->where('salary_slips.year', $year)
            // ->groupBy('users.id')
            // ->orderBy('users.id', 'asc')
            // ->get()
            // ->makeHidden('unreadNotifications');

            //ROLA
            $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
                ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
                ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->join('penalties', 'penalties.user_id', '=', 'users.id')
                ->select('users.id', 'users.name', 'users.email', 'users.image', 'designations.name as designation_name', 'salary_slips.net_salary', 'salary_slips.paid_on', 'salary_slips.status as salary_status', 'salary_slips.id as salary_slip_id', 'penalties.amount as amount')
                ->where('roles.name', '<>', 'client')
                ->where('salary_slips.month', $month)
                ->where('salary_slips.year', $year)
                ->where('penalties.penalty_name', 'Deduction')
                ->whereYear('penalties.created_at', '=', $year)
                ->whereMonth('penalties.created_at', '=', $month)
                ->groupBy('users.id')
                ->orderBy('users.id', 'asc')
                ->get()
                ->makeHidden('unreadNotifications');


            $ind = 0;
            $tBasic = 0.0;
            $tAllow = 0.0;
            $tTotal = 0.0;
            $tEar1 = 0.0;
            $tAccuir = 0.0;
            $tDed1 = 0.0;
            $tDed2 = 0.0;
            $tTDS = 0.0;
            $tDiffOthers = 0.0;
            $tTdeduc = 0.0;
            $tNet = 0.0;

            // $tOthersdDed = 0.0; //total other deductions
            $reasonOtherDed = array(); //reasons why the user had

            $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;
            foreach ($users as $user) {
                $employeeSal = EmployeeMonthlySalary::employeeNetSalary($user->role[0]->user_id);
                $slip = SalarySlip::where('user_id', $user->role[0]->user_id)->where('month', $month)->where('year', $year)->first();
                $salaryJson = json_decode($slip->salary_json, true);
                $earnings = $salaryJson['earnings'];
                if (sizeof($earnings) > 0) {
                    $content[$ind]['ind'] = $ind;
                    $content[$ind]['ind'] = ' ' . ($content[$ind]['ind'] + 1);
                    $content[$ind]['name'] = $user->name;
                    $content[$ind]['designation'] = $user->designation_name;
                    $content[$ind]['NoOfDays'] = ' ' . $slip->pay_days;
                    $content[$ind]['effectedBasic'] = round($slip->basic_salary, 2);
                    $content[$ind]['Basic'] = round($employeeSal['initialSalary'], 2);
                    $tBasic += $content[$ind]['Basic'];
                    $alla = $employeeSal['allowances'];
                    $content[$ind]['effectedAllowances'] = round($alla * ($slip->pay_days / $daysInMonth), 2);
                    $content[$ind]['Allowance'] = round($alla, 2);
                    $tAllow += $content[$ind]['Allowance'];
                    $content[$ind]['Total'] = $content[$ind]['Allowance'] + $content[$ind]['Basic'];
                    $tTotal += $content[$ind]['Total'];
                    $content[$ind]['ear1'] = 0.0;
                    $i = 1;
                    $content[$ind]['OtherDifferences'] = round($content[$ind]['Basic'] + $content[$ind]['Allowance']);
                    if (sizeof($earnings) > 0) {
                        foreach ($earnings as $key => $value) {
                            $content[$ind]['EffectedEar' . $i] = round($value, 1);
                            if ($slip->pay_days == 0) {
                                $content[$ind]['ear' . $i] = round($value * (0), 1);
                            } else {
                                $content[$ind]['ear' . $i] = round($value * ($daysInMonth / $slip->pay_days), 1);
                            }
                            $content[$ind]['OtherDifferences'] += $content[$ind]['ear' . $i] - $content[$ind]['EffectedEar' . $i];
                            $i++;
                        }
                    } else {
                        $content[$ind]['ear' . $i] = 0.0;
                    }
                    $content[$ind]['OtherDifferences'] -= round($content[$ind]['effectedBasic'] + $content[$ind]['effectedAllowances'], 2);
                    $tDiffOthers += $content[$ind]['OtherDifferences'];
                    $content[$ind]['OtherDifferences'] = ' ' . round($content[$ind]['OtherDifferences'], 0);
                    $tEar1 += $content[$ind]['ear1'];
                    $content[$ind]['TotalAccruals'] = $content[$ind]['Total'] + $content[$ind]['ear1'];
                    $tAccuir += $content[$ind]['TotalAccruals'];
                    $deductions = $salaryJson['deductions'];
                    $i = 1;
                    $content[$ind]['ded1'] = 0.0;
                    $content[$ind]['ded2'] = 0.0;
                    $content[$ind]['TDS'] = 0.0;
                    $content[$ind]['Total Penalty Duration'] = 0.0;

                    // $content[$ind]['Total Penalty Duration'] = $salaryJson['Total Penalty Duration'];

                    // rola
                    // $tOthersdDed = 0.0; //total other deductions
                    //    $tOthersdDed=$salaryJson['Total Penalty Duration'];
                    $reasonOtherDed = 0.0;
                    // $content[$ind]['Total Penalty Duration']
                    // $content[$ind]['OtherDifferences'] = $content[$ind]['OtherDifferences'] + $tOthersdDed;

                    if (sizeof($deductions) > 0) {
                        foreach ($deductions as $key => $value) {
                            if ($key == 'TDS') {
                                $content[$ind]['TDS'] = round($value, 1);
                            }
                            //rola
                            else if ($key == 'Total Penalty Duration') {
                                //  $content[$ind]['Total Penalty Duration'] = round($value, 1);
                                $content[$ind]['Total Penalty Duration'] = $value;

                                $content[$ind]['OtherDifferences'] = $content[$ind]['OtherDifferences'] + $content[$ind]['Total Penalty Duration'];

                                //  $salaryJson['Total Penalty Duration']

                            } else {
                                $content[$ind]['ded' . $i] = round($value, 1);
                            }


                            $i++;
                        }
                    }

                    $tDed1 += $content[$ind]['ded1'];
                    $tDed2 += $content[$ind]['ded2'];
                    $tTDS += $content[$ind]['TDS'];
                    $content[$ind]['TotalDeductions'] = $content[$ind]['TDS'] + $content[$ind]['ded1'] + $content[$ind]['ded2'] + $content[$ind]['OtherDifferences'];
                    $tTdeduc += $content[$ind]['TotalDeductions'];
                    $content[$ind]['Net'] = $slip->net_salary;
                    $tNet += $content[$ind]['Net'];

                    //rola
                    $userId = $user->id;
                    $employeeDeta = EmployeeDetails::where('user_id', $userId)->first();

                    $joiningDate = Carbon::parse($employeeDeta->joining_date)->setTimezone($this->global->timezone);
                    if ($endDate->greaterThan($joiningDate)) {
                        $holidays = Holiday::getHolidayByDates($startDate->toDateString(), $endDate->toDateString())->count(); // Getting Holiday Data
                        $totalWorkingDays = $daysInMonth - $holidays;
                        $presentCount = Attendance::countDaysPresentByUser($startDate, $endDate, $userId); // Getting Attendance Data
                        $lateCount = Attendance::countDaysLateByUser($startDate, $endDate, $userId); // Getting Attendance Data
                        $permissionCount = Attendance::countDaysPermissionsByUser($startDate, $endDate, $userId); // Getting Attendance Data
                        $halfCount = Attendance::countHalfDaysByUser($startDate, $endDate, $userId); // Getting Attendance Data
                        $absentCount = $totalWorkingDays - $presentCount;
                        $leaveCount = Leave::where('user_id', $userId)
                            ->where('leave_date', '>=', $startDate)
                            ->where('leave_date', '<=', $endDate)
                            ->where('status', 'approved')
                            // rolla added 
                            ->where('paid','no')
                            ->count();
                        $payDays = $presentCount + $holidays;
                        $payDayOrg = $payDays;

                        // ??????????????????????????????????
                        if ($payDays > $daysInMonth) {
                            $payDays = $daysInMonth;
                        }
                        ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        //rola
                //sum the amount of duration for the deductions days 
                 $penality_durations_currency = Penalties::select('penalties.amount')->
                    where('penalties.user_id', '=', $userId)->where('penalties.penalty_name', '=', 'Deduction')->where('penalties.currency', '=', 'days')->
                    whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->sum('penalties.amount');

                        if ($endDatePrev->greaterThan($joiningDate)) {
                            $daysInMonthPrev = Carbon::parse('01-' . $monthPrev . '-' . $yearPrev)->daysInMonth;
                            $holidaysPrev = Holiday::getHolidayByDates($startDatePrev->toDateString(), $endDatePrev->toDateString())->count();
                            $totalWorkingDaysPrev = $daysInMonthPrev - $holidaysPrev;
                            $presentCountPrev = Attendance::countDaysPresentByUser($startDatePrev, $endDatePrev, $userId);
                            if (($totalWorkingDaysPrev - $presentCountPrev) > 0) {
                                // $reasonOtherDed['previousMonthAbsence'] ='preMonthAbsence'. ($totalWorkingDaysPrev - $presentCountPrev) . ' غ ';

                                $content[$ind]['previousMonthAbsence'] = 'preMonthAbsence' . ($totalWorkingDaysPrev - $presentCountPrev) . ' غ ';
                            } else {
                                // $reasonOtherDed['previousMonthAbsence'] = '--';
                                $content[$ind]['previousMonthAbsence'] = '--';
                            }
                        }
                        //// gave error
                        else {
                            $content[$ind]['previousMonthAbsence'] = '--';
                            //    $reasonOtherDed['previousMonthAbsence'] = '--';

                        }

                        if ($absentCount > 0) {
                            $content[$ind]['thisMonthAbsence'] = 'absent' . $absentCount . ' غ ';
                            // $reasonOtherDed['thisMonthAbsence'] ='absent 5 غ ';

                        }
                        //// gave error
                        else {
                            $content[$ind]['thisMonthAbsence'] = '--';
                        }

                        if ($lateCount > 0) {
                            // for all late count whether its late or half late 
                            $content[$ind]['lateCount'] = $lateCount . ' تاخير ';
                        }
                        //// gave error
                        else {
                            $content[$ind]['lateCount'] = '--';
                        }

                        if ($permissionCount > 0) {
                            $content[$ind]['permissions'] = $permissionCount . ' اذن ';
                        }
                        //// gave error
                        else {
                            $content[$ind]['permission'] = '--';
                        }
                        // if ($holidays > 0) {
                        //     $reasonOtherDed['holidays'] = $holidays . ' أ ';
                        // } else {
                        //     $reasonOtherDed['holidays'] = '';
                        // }
                        if ($leaveCount > 0) {
                            $content[$ind]['leaveCount'] = $leaveCount . ' عارضه ';
                        } else {
                            $content[$ind]['leaveCount'] = '--';
                        }
                        // if ($payDays > 0) {
                        //     $content[$ind]['presence'] = $payDays . ' خضور';
                        // } else {
                        //     $content[$ind]['presence'] = '--';
                        // }

                        // total غياب with out paid salary  
                        if (($presentCount + $absentCount - $leaveCount) >0) {
                        //    $markAbsentUnpaid  
                        $content[$ind]['markAbsentUnpaid'] = $presentCount + $absentCount - $leaveCount . 'غ';

                        } else{
                            $content[$ind]['markAbsentUnpaid'] = '--';
                        }

                        if (($payDays  -intval($lateCount / 3))>0) {
                            // $markLate3Days1AbsentUnpaid
                            //interval returns integr numbe only
                            $content[$ind]['markLate3Days1AbsentUnpaid']=$payDays-intval($lateCount / 3). 'ت';
                          
                        }
                        else{
                            $content[$ind]['markLate3Days1AbsentUnpaid'] = '--';
                        }
                        if (($payDays -  intval($permissionCount / 3))>0) {
                            // $markPermission3Days1AbsentUnpaid
                            
                            
                            $content[$ind]['markPermission3Days1AbsentUnpaid']= $payDays -  intval($permissionCount / 3). 'اذن بدون راتب';
                        }
                        else{
                            $content[$ind]['markPermission3Days1AbsentUnpaid'] = '--';
                        }
                        if (($payDays-intval($halfCount / 2))>0) {
                            // $markLate2HalfDay1AbsentUnpaid
                            
                            $content[$ind]['markLate2HalfDay1AbsentUnpaid']=$payDays-intval($halfCount / 2). 'غياب  يومين و نصف';
                        } else{
                            $content[$ind]['markLate2HalfDay1AbsentUnpaid'] = '--';
                        }

                        if ($penality_durations_currency != 0) {

                            $content[$ind]['penalityDuration'] = $penality_durations_currency . 'أيام';
                        } else {
                            $content[$ind]['penalityDuration'] = '';
    
                        }
        
                        // if ($payDays > $daysInMonth) {
                        //     $payDays = $daysInMonth;
                        // }


                        
                        /////////////////////////////////////////////////////////////////////////////////////////////////////////////
                    } else {

                        $content[$ind]['previousMonthAbsence'] = '==';
                        $content[$ind]['thisMonthAbsence'] = '==';
                        $content[$ind]['late'] = '==';
                        $content[$ind]['holidays'] = '==';
                        $content[$ind]['leaveCount'] = '==';
                        $content[$ind]['presence'] = '==';
                        $content[$ind]['permission'] = '==';
                        $content[$ind]['penalityDuration'] = '==';
                    }



                    //////////////////////////////////////////
                    $content[$ind]['reasonOtherDed'] = $reasonOtherDed;

                    $ind++;
                }

                $employeeDetails = EmployeeDetails::where('user_id', $user)->first(); //1st reocrd for a sepcific user 
                // EmployeeMonthlySalary::employeeNetSalary($user->role[0]->user_id);


            }


            $this->totalBasic = $this->enToAr($tBasic);
            $this->totalAllow = $this->enToAr($tAllow);
            $this->totalTotal = $this->enToAr($tTotal);
            $this->totalEar1 = $this->enToAr($tEar1);
            $this->totalAccuir = $this->enToAr($tAccuir);
            $this->totalDed1 = $this->enToAr($tDed1);
            $this->totalDed2 = $this->enToAr($tDed2);
            $this->totalTDS = $this->enToAr($tTDS);
            $this->totalTdeduc = $this->enToAr($tTdeduc);
            $this->totalNet = $this->enToAr($tNet);
            $this->tDiffOthers = $this->enToAr($tDiffOthers);


            $this->contents = $content;
            $this->arabicTotalAmount = 'فقط' . $this->enToAr($tNet) . ' جنية مصري لاغير ';
            $this->arabicTitle = 'كشف صرف مرتبات الاداريين المؤمن عليهم ' . __('payroll::modules.mon' . $month) . ' ' . $this->enToAr($year);
            //return $content;

            /////////
            $documentFileName = 'allEmployeesSlip.pdf';


            
            $view = View::make('payroll::payroll.showMonthlyPayrollList', $this->data);
            $html_content = $view->render();

            $pdf = App('TCPDF');
            $pdf->SetFont('aealarabiya', '', 10);

            $pdf->SetTitle('Report');
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(TRUE, 5);
            $pdf->writeHTML($html_content, true, false, true, false, '');
            $pdf->Output($documentFileName);

            ////////////



            //return view('payroll::payroll.showMonthlyPayrollList', $this->data);
        } else {
            $this->departments = Team::all();
            $this->designations = Designation::all();

            $now = Carbon::now();
            $this->year = $now->format('Y');
            $this->month = $now->format('m');
            $this->salaryPaymentMethods = SalaryPaymentMethod::all();

            return view('payroll::payroll.index', $this->data);
        }
    }


    public function showMonthlyPayrollListNotInsured($month, $year)
    {
        if ($month > 0 && $year > 0) {
            // if ($month == 1) {
            //     $monthPrev = 12;
            //     $yearPrev = $year - 1;
            // } else {
            //     $monthPrev = $month - 1;
            //     $yearPrev = $year; 
            // }

            $content = array();
            $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
                ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
                ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
                ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.id', 'users.name', 'users.email', 'users.image', 'designations.name as designation_name', 'salary_slips.net_salary', 'salary_slips.paid_on', 'salary_slips.status as salary_status', 'salary_slips.id as salary_slip_id')
                ->where('roles.name', '<>', 'client')
                ->where('salary_slips.month', $month)
                ->where('salary_slips.year', $year)
                ->groupBy('users.id')
                ->orderBy('users.id', 'asc')
                ->get()
                ->makeHidden('unreadNotifications');
            $ind = 0;
            $tBasic = 0.0;
            $tAllow = 0.0;
            $tTotal = 0.0;
            $tEar1 = 0.0;
            $tAccuir = 0.0;
            $tDed1 = 0.0;
            $tDed2 = 0.0;
            $tTDS = 0.0;
            $tDiffOthers = 0.0;
            $tTdeduc = 0.0;
            $tNet = 0.0;
            $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;
            foreach ($users as $user) {
                $employeeSal = EmployeeMonthlySalary::employeeNetSalary($user->role[0]->user_id);
                $slip = SalarySlip::where('user_id', $user->role[0]->user_id)->where('month', $month)->where('year', $year)->first();
                $salaryJson = json_decode($slip->salary_json, true);
                $earnings = $salaryJson['earnings'];
                if (!sizeof($earnings) > 0) {
                    $content[$ind]['ind'] = $ind;
                    $content[$ind]['ind'] = ' ' . ($content[$ind]['ind'] + 1);
                    $content[$ind]['name'] = $user->name;
                    $content[$ind]['designation'] = $user->designation_name;
                    $content[$ind]['NoOfDays'] = ' ' . $slip->pay_days;
                    $content[$ind]['effectedBasic'] = round($slip->basic_salary, 2);
                    $content[$ind]['Basic'] = round($employeeSal['initialSalary'], 2);
                    $tBasic += $content[$ind]['Basic'];
                    $alla = $employeeSal['allowances'];
                    $content[$ind]['effectedAllowances'] = round($alla * ($slip->pay_days / $daysInMonth), 2);
                    $content[$ind]['Allowance'] = round($alla, 2);
                    $tAllow += $content[$ind]['Allowance'];
                    $content[$ind]['Total'] = $content[$ind]['Allowance'] + $content[$ind]['Basic'];
                    $tTotal += $content[$ind]['Total'];
                    $content[$ind]['ear1'] = 0.0;
                    $i = 1;
                    $content[$ind]['OtherDifferences'] = round($content[$ind]['Basic'] + $content[$ind]['Allowance']);
                    if (sizeof($earnings) > 0) {
                        foreach ($earnings as $key => $value) {
                            $content[$ind]['EffectedEar' . $i] = round($value, 1);
                            if ($slip->pay_days == 0) {
                                $content[$ind]['ear' . $i] = round($value * (0), 1);
                            } else {
                                $content[$ind]['ear' . $i] = round($value * ($daysInMonth / $slip->pay_days), 1);
                            }
                            $content[$ind]['OtherDifferences'] += $content[$ind]['ear' . $i] - $content[$ind]['EffectedEar' . $i];
                            $i++;
                        }
                    } else {
                        $content[$ind]['ear' . $i] = 0.0;
                    }
                    $content[$ind]['OtherDifferences'] -= round($content[$ind]['effectedBasic'] + $content[$ind]['effectedAllowances'], 2);
                    $tDiffOthers += $content[$ind]['OtherDifferences'];
                    $content[$ind]['OtherDifferences'] = ' ' . round($content[$ind]['OtherDifferences'], 0);
                    $tEar1 += $content[$ind]['ear1'];
                    $content[$ind]['TotalAccruals'] = $content[$ind]['Total'] + $content[$ind]['ear1'];
                    $tAccuir += $content[$ind]['TotalAccruals'];
                    $deductions = $salaryJson['deductions'];
                    $i = 1;
                    $content[$ind]['ded1'] = 0.0;
                    $content[$ind]['ded2'] = 0.0;
                    $content[$ind]['TDS'] = 0.0;
                    if (sizeof($deductions) > 0) {
                        foreach ($deductions as $key => $value) {
                            if ($key == 'TDS') {
                                $content[$ind]['TDS'] = round($value, 1);
                            } else {
                                $content[$ind]['ded' . $i] = round($value, 1);
                            }
                            $i++;
                        }
                    }
                    $tDed1 += $content[$ind]['ded1'];
                    $tDed2 += $content[$ind]['ded2'];
                    $tTDS += $content[$ind]['TDS'];
                    $content[$ind]['TotalDeductions'] = $content[$ind]['TDS'] + $content[$ind]['ded1'] + $content[$ind]['ded2'] + $content[$ind]['OtherDifferences'];
                    $tTdeduc += $content[$ind]['TotalDeductions'];
                    $content[$ind]['Net'] = $slip->net_salary;
                    $tNet += $content[$ind]['Net'];
                    $ind++;
                }

            }

            $this->totalBasic = $this->enToAr($tBasic);
            $this->totalAllow = $this->enToAr($tAllow);
            $this->totalTotal = $this->enToAr($tTotal);
            $this->totalEar1 = $this->enToAr($tEar1);
            $this->totalAccuir = $this->enToAr($tAccuir);
            $this->totalDed1 = $this->enToAr($tDed1);
            $this->totalDed2 = $this->enToAr($tDed2);
            $this->totalTDS = $this->enToAr($tTDS);
            $this->totalTdeduc = $this->enToAr($tTdeduc);
            $this->totalNet = $this->enToAr($tNet);
            $this->tDiffOthers = $this->enToAr($tDiffOthers);


            $this->contents = $content;
            $this->arabicTotalAmount = 'فقط' . $this->enToAr($tNet) . ' جنية مصري لاغير ';
            $this->arabicTitle = 'كشف صرف مرتبات الاداريين الغير المؤمن عليهم ' . __('payroll::modules.mon' . $month) . ' ' . $this->enToAr($year);
            //return $content;

            /////////
            //rola changed the name of pdf 
            // $documentFileName = 'allEmployeesSlip.pdf';
            $documentFileName = 'EmployeeSlipNotInsured.pdf';

            $view = View::make('payroll::payroll.showMonthlyPayrollList', $this->data);
            $html_content = $view->render();

            $pdf = App('TCPDF');
            $pdf->SetFont('aealarabiya', '', 10);

            $pdf->SetTitle('Report');
            $pdf->AddPage('L', 'A4');
            $pdf->SetAutoPageBreak(TRUE, 5);
            $pdf->writeHTML($html_content, true, false, true, false, '');
            $pdf->Output($documentFileName);

            ////////////



            //return view('payroll::payroll.showMonthlyPayrollList', $this->data);
        } else {
            $this->departments = Team::all();
            $this->designations = Designation::all();

            $now = Carbon::now();
            $this->year = $now->format('Y');
            $this->month = $now->format('m');
            $this->salaryPaymentMethods = SalaryPaymentMethod::all();

            // return view('payroll::payroll.index', $this->data);

            return view('payroll::payroll.index', $this->data);
        }
    }
    public function salaryResources($month, $year)
    {
        $this->contents = array();
        if ($month > 0 && $year > 0) {
            if ($month == 1) {
                $monthPrev = 12;
                $yearPrev = $year - 1;
            } else {
                $monthPrev = $month - 1;
                $yearPrev = $year;
            }

            $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;
            $startDate = Carbon::parse(Carbon::parse('01-' . $month . '-' . $year))->startOfMonth();
            $startDatePrev = Carbon::parse(Carbon::parse('01-' . $monthPrev . '-' . $yearPrev))->startOfMonth();
            $endDate = Carbon::parse(Carbon::parse('01-' . $month . '-' . $year))->endOfMonth();
            $endDatePrev = Carbon::parse(Carbon::parse('01-' . $monthPrev . '-' . $yearPrev))->endOfMonth();
            $users = User::allEmployees();
            $ind = 1;
            foreach ($users as $user) {
                $userId = $user->id;
                $employeeDetails = EmployeeDetails::where('user_id', $userId)->first();

                //rola
                //sum the amount of duration for the deductions days 
                $penality_durations_currency = Penalties::select('penalties.amount')->
                    where('penalties.user_id', '=', $userId)->where('penalties.penalty_name', '=', 'Deduction')->where('penalties.currency', '=', 'days')->
                    whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->sum('penalties.amount');

                $joiningDate = Carbon::parse($employeeDetails->joining_date)->setTimezone($this->global->timezone);
                if ($endDate->greaterThan($joiningDate)) {
                    $holidays = Holiday::getHolidayByDates($startDate->toDateString(), $endDate->toDateString())->count(); // Getting Holiday Data
                    $totalWorkingDays = $daysInMonth - $holidays;
                    $presentCount = Attendance::countDaysPresentByUser($startDate, $endDate, $userId); // Getting Attendance Data
                    $lateCount = Attendance::countDaysLateByUser($startDate, $endDate, $userId); // Getting Attendance Data
                    $permissionCount = Attendance::countDaysPermissionsByUser($startDate, $endDate, $userId); // Getting Attendance Data
                    $halfCount = Attendance::countHalfDaysByUser($startDate, $endDate, $userId); // Getting Attendance Data
                    $absentCount = $totalWorkingDays - $presentCount;
                    $leaveCount = Leave::where('user_id', $userId)
                        ->where('leave_date', '>=', $startDate)
                        ->where('leave_date', '<=', $endDate)
                        ->where('status', 'approved')
                        ->count();
                    $payDays = $presentCount + $holidays;
                    $payDayOrg = $payDays;
                    if ($payDays > $daysInMonth) {
                        $payDays = $daysInMonth;
                    }
                    $content[$ind]['ind'] = ' ' . $ind;
                    $content[$ind]['name'] = $user->name;
                    if ($endDatePrev->greaterThan($joiningDate)) {
                        $daysInMonthPrev = Carbon::parse('01-' . $monthPrev . '-' . $yearPrev)->daysInMonth;
                        $holidaysPrev = Holiday::getHolidayByDates($startDatePrev->toDateString(), $endDatePrev->toDateString())->count();
                        $totalWorkingDaysPrev = $daysInMonthPrev - $holidaysPrev;
                        $presentCountPrev = Attendance::countDaysPresentByUser($startDatePrev, $endDatePrev, $userId);
                        if (($totalWorkingDaysPrev - $presentCountPrev) > 0) {
                            $content[$ind]['previousMonthAbsence'] = ($totalWorkingDaysPrev - $presentCountPrev) . ' غ ';
                        } else {
                            $content[$ind]['previousMonthAbsence'] = '';
                        }
                    } else {
                        $content[$ind]['previousMonthAbsence'] = '';
                    }
                    if ($absentCount > 0) {
                        $content[$ind]['thisMonthAbsence'] = $absentCount . ' غ ';
                    } else {
                        $content[$ind]['thisMonthAbsence'] = '';
                    }
                    if ($lateCount > 0) {
                        $content[$ind]['late'] = $lateCount . ' ت ';
                    } else {
                        $content[$ind]['late'] = '';
                    }
                    if ($permissionCount > 0) {
                        $content[$ind]['permission'] = $permissionCount . ' اذن ';
                    } else {
                        $content[$ind]['permission'] = '';
                    }
                    if ($holidays > 0) {
                        $content[$ind]['holidays'] = $holidays . ' أ ';
                    } else {
                        $content[$ind]['holidays'] = '';
                    }
                    if ($leaveCount > 0) {
                        $content[$ind]['leaveCount'] = $leaveCount . ' عارضه ';
                    } else {
                        $content[$ind]['leaveCount'] = '';
                    }
                    if ($payDays > 0) {
                        $content[$ind]['presence'] = $payDays . ' ';
                    } else {
                        $content[$ind]['presence'] = '';
                    }
                    //rola
                    if ($penality_durations_currency != 0) {

                        $content[$ind]['penalityDuration'] = $penality_durations_currency . 'أيام';
                    } else {
                        $content[$ind]['penalityDuration'] = '';

                    }
                } else {
                    $content[$ind]['ind'] = ' ' . $ind;
                    $content[$ind]['name'] = $user->name;
                    $content[$ind]['previousMonthAbsence'] = '';
                    $content[$ind]['thisMonthAbsence'] = '';
                    $content[$ind]['late'] = '';
                    $content[$ind]['holidays'] = '';
                    $content[$ind]['leaveCount'] = '';
                    $content[$ind]['presence'] = '';
                    $content[$ind]['permission'] = '';
                    $content[$ind]['penalityDuration'] = '';
                }
                $ind++;
            }
            $this->contents = $content;
        }
        $this->arabicTitle = 'مصدر مرتبات العاملين عن شهر ' . __('payroll::modules.mon' . $month) . ' ' . $this->enToAr($year);
        /////////
        $documentFileName = 'EmployeeSalaryResources.pdf';
        $view = View::make('payroll::payroll.salaryResources', $this->data);
        $html_content = $view->render();
        $pdf = App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetTitle('Report');
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);
    }
    function enToAr($string)
    { 
        return strtr($string, array('0' => '٠', '1' => '١', '2' => '٢', '3' => '٣', '4' => '٤', '5' => '٥', '6' => '٦', '7' => '٧', '8' => '٨', '9' => '٩'));
    }
    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('payroll::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

        $this->salarySlip = SalarySlip::with('user', 'user.employeeDetail', 'salary_group', 'salary_payment_method')->findOrFail($id);



        //rola 
        //  $penality_duration = Penalties::select('penalties.id', 'users.name', 'penalties.penalty_name', 'penalties.status', 'penalties.details', 'penalties.amount', 'penalties.currency')
        //     ->join('users', 'users.id', '=', 'penalties.user_id')->where('penalties.user_id', $this->salarySlip->user_id);
        // $this->penality_durations = Penalties::
        //  select( 'penalties.penalty_name','penalties.amount', 'penalties.currency')->
        //   where('penalties.user_id', $this->salarySlip->user_id)->where('penalties.penalty_name', 'Deduction');
        //     // ->orderBy('date', 'asc')

        $this->penality_durations = Penalties::select('penalties.penalty_name', 'penalties.amount', 'penalties.currency', 'penalties.created_at')->
            where('penalties.user_id', $this->salarySlip->user_id)->where('penalties.penalty_name', 'Deduction')->
            whereYear('created_at', '=', $this->salarySlip->year)->whereMonth('created_at', '=', $this->salarySlip->month)
            ->get();


        // $this->global->penality_durations_currency = Penalties::select('penalties.penalty_name', 'penalties.amount', 'penalties.currency', 'penalties.created_at')->
        // where('penalties.user_id','=', $this->salarySlip->user_id)->where('penalties.penalty_name','=', 'Deduction')->where('penalties.currency','=', 'days')->
        // whereYear('created_at', '=',  $this->salarySlip->year)->whereMonth('created_at', '=', $this->salarySlip->month)->sum('penalties.amount');


        // ->orderBy('date', 'asc')

        $daysInMonth = Carbon::parse('01-' . $this->salarySlip->month . '-' . $this->salarySlip->year)->daysInMonth;

        $this->days_In_Month = $daysInMonth;
        if ($this->user->hasRole('admin') || $this->salarySlip->user_id == $this->user->id) {
            $salaryJson = json_decode($this->salarySlip->salary_json, true);
            $this->salaryBasic = round($this->salarySlip->basic_salary, 3);
            $this->salaryAllowances = EmployeeMonthlySalary::where('user_id', $this->salarySlip->user_id)->where('type', 'allowances')->orderBy('date', 'asc')->sum('amount');
            $this->salaryAllowances = $this->salaryAllowances * ($this->salarySlip->pay_days / $daysInMonth);
            $this->salaryAllowances = round($this->salaryAllowances, 3);

            $this->salaryIncremenetes = EmployeeMonthlySalary::where('user_id', $this->salarySlip->user_id)->where('type', 'increment')->orderBy('date', 'asc')->sum('amount');
            $this->salaryIncremenetes = $this->salaryIncremenetes * ($this->salarySlip->pay_days / $daysInMonth);

            $this->earnings = $salaryJson['earnings'];
            $this->deductions = $salaryJson['deductions'];
            $extraJson = json_decode($this->salarySlip->extra_json, true);

            //rola
            //how much the employee take in a day
            $this->daily_amount_salary = $this->salaryBasic / $daysInMonth;
            $this->global->penalty_deduction_value = 0;

            foreach ($this->penality_durations as $this->penality_duration_total) {

                //  if($key=='days'){
                if ($this->penality_duration_total->currency == "days") {


                    $this->global->penalty_deduction_value = $this->global->penalty_deduction_value + ($this->daily_amount_salary * $this->penality_duration_total->amount);
                    // $this->penality_durations_amount='555';
                }
            }

            // rounded to 2 decimals
            $this->global->penalty_deduction_value = round($this->global->penalty_deduction_value, 2);

            // $this->salarySlip->total_deductions = $this->salarySlip->total_deductions + $this->global->penalty_deduction_value;
            // $this->salarySlip->net_salary = $this->salarySlip->net_salary - $this->salarySlip->total_deductions;







            if (!is_null($extraJson)) {
                $this->earningsExtra = $extraJson['earnings'];
                $this->deductionsExtra = $extraJson['deductions'];
            } else {
                $this->earningsExtra = "";
                $this->deductionsExtra = "";
            }

            if ($this->earningsExtra == "") {
                $this->earningsExtra = array();
            }

            if ($this->deductionsExtra == "") {
                $this->deductionsExtra = array();
            }
            $view = view('payroll::payroll.show', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'view' => $view]);
        } else {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $this->salarySlip = SalarySlip::with('user', 'user.employeeDetail', 'salary_group', 'salary_payment_method')->findOrFail($id);
        $salaryJson = json_decode($this->salarySlip->salary_json, true);
        $this->earnings = $salaryJson['earnings'];
        $this->salaryBasic = EmployeeMonthlySalary::where('user_id', $this->salarySlip->user_id)->where('type', 'initial')->orderBy('date', 'asc')->sum('amount');

        $this->salaryAllowances = EmployeeMonthlySalary::where('user_id', $this->salarySlip->user_id)->where('type', 'allowances')->orderBy('date', 'asc')->sum('amount');

        $this->salaryIncremenetes = EmployeeMonthlySalary::where('user_id', $this->salarySlip->user_id)->where('type', 'increment')->orderBy('date', 'asc')->sum('amount');

        //rola 
        //// $this->durations = Penlatyduraton::all();
        $this->p_durations_select = PenaltiesDurations::all();


        $this->penality_durations = Penalties::select('penalties.penalty_name', 'penalties.amount', 'penalties.currency')->
            where('penalties.user_id', $this->salarySlip->user_id)->where('penalties.penalty_name', 'Deduction')->get();
        // ->orderBy('date', 'asc')

        // $month = $request->month;
        // $year = $request->year;
        // $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;



        $this->deductions = $salaryJson['deductions'];
        $extraJson = json_decode($this->salarySlip->extra_json, true);




        if (!is_null($extraJson)) {
            $this->earningsExtra = $extraJson['earnings'];
            $this->deductionsExtra = $extraJson['deductions'];
        } else {
            $this->earningsExtra = "";
            $this->deductionsExtra = "";
        }

        if ($this->earningsExtra == "") {
            $this->earningsExtra = array();
        }

        if ($this->deductionsExtra == "") {
            $this->deductionsExtra = array();
        }
        $this->salaryPaymentMethods = SalaryPaymentMethod::all();
        return view('payroll::payroll.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $grossEarning = $request->basic_salary;
        $totalDeductions = 0;
        $reimbursement = $request->expense_claims;
        $earningsName = $request->earnings_name;
        $earnings = $request->earnings;
        $deductionsName = $request->deductions_name;
        $deductions = $request->deductions ? $request->deductions : array();
        $extraEarningsName = $request->extra_earnings_name;
        $extraEarnings = $request->extra_earnings;
        $extraDeductionsName = $request->extra_deductions_name;
        $extraDeductions = $request->extra_deductions;

        $earningsArray = array();
        $deductionsArray = array();
        $extraEarningsArray = array();
        $extraDeductionsArray = array();

        if ($earnings != "") {
            foreach ($earnings as $key => $value) {
                $earningsArray[$earningsName[$key]] = floatval($value);
                $grossEarning = $grossEarning + $earningsArray[$earningsName[$key]];
            }
        }

        foreach ($deductions as $key => $value) {
            $deductionsArray[$deductionsName[$key]] = floatval($value);
            $totalDeductions = $totalDeductions + $deductionsArray[$deductionsName[$key]];
        }

        $salaryComponents = [
            'earnings' => $earningsArray,
            'deductions' => $deductionsArray
        ];
        $salaryComponentsJson = json_encode($salaryComponents);

        if ($extraEarnings != "") {
            foreach ($extraEarnings as $key => $value) {
                $extraEarningsArray[$extraEarningsName[$key]] = floatval($value);
                $grossEarning = $grossEarning + $extraEarningsArray[$extraEarningsName[$key]];
            }
        }

        if ($extraDeductions != "") {
            foreach ($extraDeductions as $key => $value) {
                $extraDeductionsArray[$extraDeductionsName[$key]] = floatval($value);
                $totalDeductions = $totalDeductions + $extraDeductionsArray[$extraDeductionsName[$key]];
            }
        }

        $extraSalaryComponents = [
            'earnings' => $extraEarningsArray,
            'deductions' => $extraDeductionsArray
        ];
        $extraSalaryComponentsJson = json_encode($extraSalaryComponents);

        $netSalary = $grossEarning - $totalDeductions + $reimbursement;

        $salarySlip = SalarySlip::findOrFail($id);

        if ($request->paid_on != "") {
            $salarySlip->paid_on = Carbon::createFromFormat($this->global->date_format, $request->paid_on)->format('Y-m-d');
        }

        if ($request->salary_payment_method_id != "") {
            $salarySlip->salary_payment_method_id = $request->salary_payment_method_id;
        }

        $salarySlip->status = $request->status;
        $salarySlip->expense_claims = $request->expense_claims;
        $salarySlip->basic_salary = $request->basic_salary;
        $salarySlip->salary_json = $salaryComponentsJson;
        $salarySlip->extra_json = $extraSalaryComponentsJson;
        $salarySlip->tds = isset($deductionsArray['TDS']) ? $deductionsArray['TDS'] : 0;
        $salarySlip->total_deductions = round(($totalDeductions), 2);
        $salarySlip->net_salary = round(($netSalary), 2);
        $salarySlip->gross_salary = round(($grossEarning), 2);
        $salarySlip->save();

        return Reply::redirect(route('admin.payroll.index'), __('messages.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        SalarySlip::destroy($id);

        return Reply::success(__('messages.deleteSuccess'));
    }

    public function data(Request $request)
    {

        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'users.email', 'users.image', 'designations.name as designation_name', 'salary_slips.net_salary', 'salary_slips.paid_on', 'salary_slips.status as salary_status', 'salary_slips.id as salary_slip_id')
            ->where('roles.name', '<>', 'client')
            ->where('salary_slips.month', $request->month)
            ->where('salary_slips.year', $request->year)
            ->groupBy('users.id')
            ->orderBy('users.id', 'asc')
            ->get()
            ->makeHidden('unreadNotifications');

        //rola added  penalties table with its conditions
        //rrrr fetch active users weather they are deleted or not
        // $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
        // ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
        // ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
        // ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
        // ->join('roles', 'roles.id', '=', 'role_user.role_id')
        // ->join('penalties', 'penalties.user_id', '=', 'users.id')
        // ->select('users.id', 'users.name', 'users.email', 'users.image', 'designations.name as designation_name', 'salary_slips.net_salary', 'salary_slips.paid_on', 'salary_slips.status as salary_status', 'salary_slips.id as salary_slip_id', 'penalties.penalty_name as penalty_name', 'penalties.amount as amount', 'penalties.currency as currency', 'penalties.created_at as created_at')
        // ->where('roles.name', '<>', 'client')
        // ->where('salary_slips.month', $request->month)
        // ->where('salary_slips.year', $request->year)
        // ->where('penalties.penalty_name', 'Deduction')
        // ->whereYear('penalties.created_at', '=', $request->year)
        // ->whereMonth('penalties.created_at', '=', $request->month)
        // ->groupBy('users.id')
        // ->orderBy('users.id', 'asc')
        // ->get()
        // ->makeHidden('unreadNotifications');

        return DataTables::of($users)

            ->addColumn('action', function ($row) {
                return '
                    <a href="javascript:;" data-salary-slip-id="' . $row->salary_slip_id . '" class="btn btn-success btn-circle show-salary-slip"
                    ><i class="fa fa-search" aria-hidden="true"></i></a> 

                    <a href="' . route('admin.payroll.edit', $row->salary_slip_id) . '" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                    <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-salary-id="' . $row->salary_slip_id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
            })
            // DISPLAYS THE NAME NET, SALARY AMOUNT, PAID ON, STATUS, ACTION editColumn('name', function ($row)
            ->editColumn('name', function ($row) {

                $image = '<img src="' . $row->image_url . '"alt="user" class="img-circle" width="30"> ';

                $designation = ($row->designation_name) ? ucwords($row->designation_name) : ' ';

                return '<div class="row"><div class="col-sm-3 col-xs-4">' . $image . '</div><div class="col-sm-9 col-xs-8"><a href="' . route('admin.employees.show', $row->id) . '" >' . ucwords($row->name) . '</a><br><span class="text-muted font-12">' . $designation . '</span></div></div>';
            })
            ->editColumn('id', function ($row) {
                return '<input type="checkbox" data-user-id="' . $row->id . '" name="salary_ids[]" value="' . $row->salary_slip_id . '" />';
            })
            // DISPLAYS THE SALARY OF EACH USER 
            ->editColumn('net_salary', function ($row) {
                return $this->global->currency->currency_symbol . sprintf('%0.2f', $row->net_salary);
            })
            ->editColumn('salary_status', function ($row) {
                if ($row->salary_status == 'generated') {
                    return '<label class="label label-inverse">' . __('payroll::modules.payroll.generated') . '</label>';
                } elseif ($row->salary_status == 'review') {
                    return '<label class="label label-info">' . __('payroll::modules.payroll.review') . '</label>';
                } elseif ($row->salary_status == 'locked') {
                    return '<label class="label label-danger">' . __('payroll::modules.payroll.locked') . '</label>';
                } elseif ($row->salary_status == 'paid') {
                    return '<label class="label label-success">' . __('payroll::modules.payroll.paid') . '</label>';
                }
                return ucwords($row->salary_status);
            })
            ->editColumn('paid_on', function ($row) {
                if (!is_null($row->paid_on)) {
                    return Carbon::parse($row->paid_on)->format($this->global->date_format);
                } else {
                    return "--";
                }
            })
            ->rawColumns(['name', 'action', 'id', 'salary_status'])
            ->make(true);
    }

    public function generatePaySlip(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $useAttendance = $request->useAttendance; //5
        $markApprovedLeavesPaid = $request->markLeavesPaid; //1
        $markAbsentUnpaid = $request->markAbsentUnpaid; // 4
        $markLate3Days1AbsentUnpaid = $request->markLate3Days1AbsentUnpaid; //2
        $markPermission3Days1AbsentUnpaid = $request->markPermission3Days1AbsentUnpaid; //6
        $markLate2HalfDay1AbsentUnpaid = $request->markLate2HalfDay1AbsentUnpaid; //3
        $includeExpenseClaims = $request->includeExpenseClaims;
        $addTimelogs = $request->addTimelogs;








        $daysInMonth = Carbon::parse('01-' . $month . '-' . $year)->daysInMonth;
        $startDate = Carbon::parse(Carbon::parse('01-' . $month . '-' . $year))->startOfMonth();
        $endDate = Carbon::parse(Carbon::parse('01-' . $month . '-' . $year))->endOfMonth();
        //    $holidays_rola=Holiday::where('date','>=',(new Carbon($startDate)))->where('date','<=',(new Carbon($endDate)))->count();

        //   $holidays_rola = Holiday::getHolidayByDates($startDate->toDateString(), $endDate->toDateString())->count();
        //  $holidays = Holiday::getHolidayByDates($startDate->toDateString(), $endDate->toDateString())->count(); // Getting Holiday Data





         if ($request->userIds) {
            $users = User::with('employeeDetail')->whereIn('users.id', $request->userIds)->get();



        } else {
            $users = User::allEmployees();
        }
        $lateCount = 0;
        $permissionCount = 0;
        $halfCount = 0;
        $payDayOrg = 0;
        $holidays = 0;
        $totalWorkingDays = 0;
        $absentUnpaid = 0;


        foreach ($users as $user) {
            $userId = $user->id;

            //rola
            //sum the amount of duration for the deductions days 
            $penality_durations_currency = Penalties::select('penalties.penalty_name', 'penalties.amount', 'penalties.currency', 'penalties.created_at')->
                where('penalties.user_id', '=', $userId)->where('penalties.penalty_name', '=', 'Deduction')->where('penalties.currency', '=', 'days')->
                whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->sum('penalties.amount');

            $employeeDetails = EmployeeDetails::where('user_id', $userId)->first(); //1st reocrd for a sepcific user 
            $joiningDate = Carbon::parse($employeeDetails->joining_date)->setTimezone($this->global->timezone);
            //i got the initial day the empolyee joins and checked if this day is greater than the end of the month
            if ($endDate->greaterThan($joiningDate)) {
                //if i requested to check the attendace of the employees
                if ($useAttendance) {
                    //i counted the
                    $holidays = Holiday::getHolidayByDates($startDate->toDateString(), $endDate->toDateString())->count(); // Getting Holiday Data

                    $totalWorkingDays = $daysInMonth - $holidays;

                    $presentCount = Attendance::countDaysPresentByUser($startDate, $endDate, $userId); // Getting Attendance Data
                    $lateCount = Attendance::countDaysLateByUser($startDate, $endDate, $userId); // Getting Attendance Data
                    $permissionCount = Attendance::countDaysPermissionsByUser($startDate, $endDate, $userId); // Getting Attendance Data

                    //repeated and not used in the code  ,  $Count  is same as $lateCount
                    // $Count = Attendance::countDaysLateByUser($startDate, $endDate, $userId); // Getting Attendance Data 
                    $halfCount = Attendance::countHalfDaysByUser($startDate, $endDate, $userId); // Getting Attendance Data



                    $absentCount = $totalWorkingDays - $presentCount;

                    $leaveCount = Leave::where('user_id', $userId)
                        ->where('leave_date', '>=', $startDate)
                        ->where('leave_date', '<=', $endDate)
                        ->where('status', 'approved')
                        ->count();

                    // if Mark Absent Days as Unpaid && Mark Approved Leaves as Paid
                    if ($markAbsentUnpaid) {
                        if ($markApprovedLeavesPaid) {
                            $presentCount = $presentCount + $leaveCount;
                            //rola
                            // $absentUnpaid = $presentCount + $leaveCount;
                        }
                    } else {
                        if ($markApprovedLeavesPaid) {
                            $presentCount = $presentCount + $absentCount;
                        } else {
                            $presentCount = $presentCount + $absentCount - $leaveCount;
                        }
                    }

                    $payDays = $presentCount + $holidays;

                } else {
                    $payDays = $daysInMonth;
                }
                $payDayOrg = $payDays;
                if ($markLate3Days1AbsentUnpaid) {
                    //interval returns integr number only
                    $daysperlate = intval($lateCount / 3);
                    $payDays = $payDays - $daysperlate;
                }
                if ($markPermission3Days1AbsentUnpaid) {
                    $daysperPermission = intval($permissionCount / 3);
                    $payDays = $payDays - $daysperPermission;
                }
                if ($markLate2HalfDay1AbsentUnpaid) {
                    $daysperhalf = intval($halfCount / 2);
                    $payDays = $payDays - $daysperhalf;
                }

                if ($payDays > $daysInMonth) {
                    $payDays = $daysInMonth;
                }
                // 10 5 $payDays =10
                //9  10




                //employeeNetSalary returns 'allowances' => $allowances,'addSalary', 'initialSalary',  'netSalary' 
                $monthlySalary = EmployeeMonthlySalary::employeeNetSalary($userId, $endDate);

                $netSalary = $monthlySalary['netSalary'] * ($payDays / $daysInMonth);
                $initialSalary = $monthlySalary['initialSalary'] * ($payDays / $daysInMonth);
                $allowances = $monthlySalary['allowances'] * ($payDays / $daysInMonth);
                $addSalary = $monthlySalary['addSalary'] * ($payDays / $daysInMonth);

                $salaryGroup = EmployeeSalaryGroup::with('salary_group.components', 'salary_group.components.component')->where('user_id', $userId)->first();
                //SalaryGroupComponent  //SalaryComponent
                $earnings = array();
                $earningsTotal = 0;
                $deductions = array();
                $deductionsTotal = 0;

                // $deductionsTotal=$deductionsTotal+ 10000;
                // $deductionsTotal=  $deductionsTotal + ($penality_durations_currency * $initialSalary);


                if (!is_null($salaryGroup)) {

                    foreach ($salaryGroup->salary_group->components as $components) {
                        // calculate earnings
                        if ($components->component->component_type == 'earning') {
                            if ($components->component->value_type == 'fixed') {
                                $netSalary = $netSalary + $components->component->component_value * ($payDays / $daysInMonth);
                                $earnings[$components->component->component_name] = floatval($components->component->component_value) * ($payDays / $daysInMonth);
                            } else {
                                $componentValue = ($components->component->component_value / 100) * $monthlySalary['initialSalary'] * ($payDays / $daysInMonth);
                                $netSalary = $netSalary + $componentValue;
                                $earnings[$components->component->component_name] = round(floatval($componentValue), 2);
                            }
                            $earningsTotal = $earningsTotal + $earnings[$components->component->component_name];
                        } else {
                            // calculate deductions
                            if ($components->component->value_type == 'fixed') {
                                $netSalary = $netSalary - $components->component->component_value;
                                $deductions[$components->component->component_name] = floatval($components->component->component_value);
                            } else {
                                $componentValue = ($components->component->component_value / 100) * $monthlySalary['initialSalary'];
                                $netSalary = $netSalary - $componentValue;
                                $deductions[$components->component->component_name] = round(floatval($componentValue), 2);
                            }

                            $deductionsTotal = $deductionsTotal + $deductions[$components->component->component_name];
                        }
                    }
                }
                $deductions['TDS'] = 0;
                $sal = ($netSalary) * 12;
                if ($sal > 75000) {
                    $salaryTdsTotal = (375 + 1500 + 2250) + (($sal - 75000) * 0.2);
                } elseif ($sal > 60000) {
                    $salaryTdsTotal = (375 + 1500) + (($sal - 60000) * 0.15);
                } elseif ($sal > 45000) {
                    $salaryTdsTotal = (375) + (($sal - 45000) * 0.1);
                } elseif ($sal > 30000) {
                    $salaryTdsTotal = ($sal - 30000) * 0.025;
                } else {
                    $salaryTdsTotal = 0;
                }
                $deductions['TDS'] = round($salaryTdsTotal / 12, 2);

                // $deductions['penality_days'] = $deductionsTotal + ($penality_durations_currency * $initialSalary);
                $deductionsTotal = $deductionsTotal + $deductions['TDS'];


                $netSalary = $netSalary - $deductions['TDS'];
                $expenseTotal = 0;
                if ($includeExpenseClaims) {
                    $expenseTotal = Expense::where(DB::raw('DATE(purchase_date)'), '>=', $startDate)
                        ->where(DB::raw('DATE(purchase_date)'), '<=', $endDate)
                        ->where('user_id', $userId)
                        ->where('status', 'approved')
                        ->sum('price');
                    $netSalary = $netSalary + $expenseTotal;
                }

                if ($addTimelogs) {
                    $earnings['Time Logs'] = ProjectTimeLog::where(DB::raw('DATE(start_time)'), '>=', $startDate)
                        ->where(DB::raw('DATE(start_time)'), '<=', $endDate)
                        ->where('user_id', $userId)
                        ->sum('earnings');
                    $netSalary = $netSalary + $earnings['Time Logs'];
                    $earnings['Time Logs'] = round($earnings['Time Logs'], 2);
                    $earningsTotal += $earnings['Time Logs'];
                }

                //rola
                $calu_daily_amount_salary = $initialSalary / $daysInMonth;
                $penality_total = $calu_daily_amount_salary * $penality_durations_currency;
                $deductions['Total Penalty Duration'] = round($penality_total, 2);
                $deductionsTotal = $deductionsTotal + $deductions['Total Penalty Duration'];
                //rola 
                // reasons why the employee got deduction
                // 1- halfday late   2-
                $reasonDeductionComponents = [
                    'total halfDay' => $halfCount,
                    'totat late count' => $lateCount,
                    'holidays' => $holidays,
                    'daysInMonth' => $daysInMonth,
                    '$presentCount + $holidays'=>$presentCount + $holidays,

                    // $payDays = $presentCount + $holidays;
                    // payDayOrg=payDays
                   'total absent count totalWorkingDays - $presentCount'=> $totalWorkingDays - $presentCount,
                    'total Absent' => $daysInMonth - $payDayOrg,
                    //total absent

                    // 'half count unpaid' => $payDays - intval($halfCount / 2),
                     //$markLate2HalfDay1AbsentUnpaid
                     '2 half day Absent' => $payDays - intval($halfCount / 2),

                    //markLate3Days1AbsentUnpaid
                    'Late Unpaid' => $payDays - intval($lateCount / 3),
                    //markPermission3Days1AbsentUnpaid
                    'Permission Absent unpaid' => $payDays - intval($permissionCount / 3),
                   

                    



                    // 'payDayOrg' => $payDayOrg,
                    // 'Absent_unpaid' => $absentCount,
                    // 'ror'=>5,
                    // 'Absent_absentCount' =>$totalWorkingDays - $presentCount,
                    // 'leave'=>$leaveCount,
                    // 'Abs_unpaid' =>$absentUnpaid,
                    // 'Abs_unpaid'=>5,
                ];

                $reasonDeductionComponentsJson = json_encode($reasonDeductionComponents);

                $salaryComponents = [
                    'earnings' => $earnings,
                    'deductions' => $deductions, //rola added penality_total to the deductions
                    'late' => $lateCount,
                    'permission' => $permissionCount,
                    'halfDay' => $halfCount,
                    'holidays' => $holidays,
                    'daysInMonth' => $daysInMonth,
                    'Absent' => $daysInMonth - $payDayOrg,
                    // 'Total Penalty Duration'=>round($penality_total,2), //rola added penality_total section in the salary_json colum in the table 
                ];

                $salaryComponentsJson = json_encode($salaryComponents);
                //rola
                // $totalPenalityDeduction = round($penality_durations_currency * $initialSalary, 2);
                // $sumT = $deductionsTotal;
                // if ((intval($sumT) - intval($deductions['TDS']) - intval($deductions[$components->component->component_name])) != intval($totalPenalityDeduction)) {
                //     $deductionsTotal = $deductionsTotal + $totalPenalityDeduction;
                // }

                $data = [
                    'user_id' => $userId,
                    'salary_group_id' => (($salaryGroup) ? $salaryGroup->salary_group_id : null),
                    'basic_salary' => round($initialSalary, 2),
                    'monthly_salary' => round($netSalary + $deductionsTotal, 2),
                    // totalAccruals
                    'net_salary' => round(($netSalary), 2),
                    'gross_salary' => round(($earningsTotal + $deductionsTotal), 2),
                    //total earnings
                    'total_deductions' => round(($deductionsTotal), 2),
                    //rola
                    // 'total_deductions' => round(($deductionsTotal+($initialSalary*$penality_durations_currency)), 2),

                    'month' => $month,
                    'year' => $year,
                    'salary_json' => $salaryComponentsJson,
                    'expense_claims' => $expenseTotal,
                    'pay_days' => $payDays,
                    //rola
                    'penality_duration' => round(($penality_total), 2),
                    'deduction_reason_json' => $reasonDeductionComponentsJson,

                ];

                $data['tds'] = $deductions['TDS'];
                SalarySlip::where('user_id', $userId)->where('month', $month)->where('year', $year)->delete();
                SalarySlip::create($data);
            }
        }
        return Reply::dataOnly(['status' => 'success']);
    }

    protected function calculateTdsSalary($userId, $joiningDate, $financialyearStart, $financialyearEnd, $payrollMonthEndDate)
    {
        $totalEarning = 0;

        if ($joiningDate->greaterThan($financialyearStart)) {
            $monthlySalary = EmployeeMonthlySalary::employeeNetSalary($userId);
            $currentSalary = $initialSalary = $monthlySalary['netSalary'];
        } else {
            $monthlySalary = EmployeeMonthlySalary::employeeNetSalary($userId, $financialyearStart);
            $currentSalary = $initialSalary = $monthlySalary['netSalary'];
        }

        $increments = EmployeeMonthlySalary::employeeIncrements($userId);
        $allowances = EmployeeMonthlySalary::employeeAllowances($userId);

        $lastIncrement = null;

        foreach ($increments as $increment) {
            $incrementDate = Carbon::parse($increment->date);
            if ($payrollMonthEndDate->greaterThan($incrementDate)) {
                if (is_null($lastIncrement)) {
                    $payDays = $incrementDate->diffInDays($joiningDate, true);
                    $perDaySalary = ($initialSalary / 30); //30 is taken as no of days in a month
                    $totalEarning = $payDays * $perDaySalary;
                    $lastIncrement = $incrementDate;
                    $currentSalary = $increment->amount + $initialSalary;
                } else {
                    $payDays = $incrementDate->diffInDays($lastIncrement, true);
                    $perDaySalary = ($currentSalary / 30);
                    $totalEarning = $totalEarning + ($payDays * $perDaySalary);
                    $lastIncrement = $incrementDate;
                    $currentSalary = $increment->amount + $currentSalary;
                }
            }
        }

        if (!is_null($lastIncrement)) {
            $payDays = $financialyearEnd->diffInDays($lastIncrement, true);
            $perDaySalary = ($currentSalary / 30);
            $totalEarning = $totalEarning + ($payDays * $perDaySalary);
        } else {
            $payDays = $financialyearEnd->diffInDays($joiningDate, true);
            $perDaySalary = ($initialSalary / 30); //30 is taken as no of days in a month
            $totalEarning = $payDays * 12;
        }

        return $totalEarning;
    }

    public function updateStatus(Request $request)
    {
        $salarySlips = SalarySlip::whereIn('id', $request->salaryIds)->get();
        $data = [
            "status" => $request->status
        ];

        if ($request->status == "paid") {
            $data['salary_payment_method_id'] = $request->paymentMethod;
            $data['paid_on'] = Carbon::createFromFormat($this->global->date_format, $request->paidOn)->toDateString();
        } else {
            $data['salary_payment_method_id'] = null;
            $data['paid_on'] = null;
        }

        foreach ($salarySlips as $key => $value) {
            $salary = SalarySlip::find($value->id);
            $salary->update($data);

            if ($request->status != 'generated') {
                $notifyUser = User::find($salary->user_id);
                $notifyUser->notify(new SalaryStatusEmail($salary));
            }
        }

        return Reply::dataOnly(['status' => 'success']);
    }

    public function downloadPdf($id)
    {
        $this->salarySlip = SalarySlip::with('user', 'user.employeeDetail', 'salary_group', 'salary_payment_method')->where('id', $id)->firstOrFail();
        $daysInMonth = Carbon::parse('01-' . $this->salarySlip->month . '-' . $this->salarySlip->year)->daysInMonth;
        $salaryJson = json_decode($this->salarySlip->salary_json, true);
        $this->earnings = $salaryJson['earnings'];
        $this->deductions = $salaryJson['deductions'];
        $this->Absent = $salaryJson['Absent'];
        $this->holidays = $salaryJson['holidays'];
        $this->late = $salaryJson['late'];
        $this->halfDay = $salaryJson['halfDay'];
        $this->permission = $salaryJson['permission'];
        $extraJson = json_decode($this->salarySlip->extra_json, true);
        if (!is_null($extraJson)) {
            $this->earningsExtra = $extraJson['earnings'];
            $this->deductionsExtra = $extraJson['deductions'];
        } else {
            $this->earningsExtra = "";
            $this->deductionsExtra = "";
        }
        if ($this->earningsExtra == "") {
            $this->earningsExtra = array();
        }
        if ($this->deductionsExtra == "") {
            $this->deductionsExtra = array();
        }
        $designation = Designation::where('id', $this->salarySlip->user->employeeDetail->designation_id)->first();
        if ($designation) {
            $this->designation_name = $designation->name;
        } else {
            $this->designation_name = "Admin";
        }

        $this->penalities = '0.0';
        $this->otherdeductions = '0.0';
        $emplsal = EmployeeMonthlySalary::employeeNetSalary($this->salarySlip->user->id);
        $effectedBasic = round($this->salarySlip->basic_salary, 3);
        $this->basic = round($emplsal['initialSalary'], 3);
        $this->allownces = $emplsal['allowances'];
        $this->allownces = round($this->allownces, 2);
        $effectedAllownces = round($this->allownces * ($this->salarySlip->pay_days / $daysInMonth), 2);
        $this->total = $this->basic + $this->allownces;
        $salaryJson = json_decode($this->salarySlip->salary_json, true);
        $earnings = $salaryJson['earnings'];
        $earningsItems = array();
        $earningsItems['ear1'] = 0.0;
        $i = 1;
        $totOtherDiff = round(($this->basic + $this->allownces) - ($effectedBasic + $effectedAllownces), 2);
        if (sizeof($earnings) > 0) {
            foreach ($earnings as $key => $value) {
                $earningsItems['affectedEar' . $i] = round($value, 2);
                $earningsItems['ear' . $i] = round($value * ($daysInMonth / $this->salarySlip->pay_days), 2);
                $totOtherDiff = round($totOtherDiff + ($earningsItems['ear' . $i] - $earningsItems['affectedEar' . $i]), 2);
                $totalAccruals = $this->total + $earningsItems['ear' . $i];
                $this->Insured = ' ';
                $i++;
            }
        } else {
            $earningsItems['ear' . $i] = 0.0;
            $totalAccruals = $this->total;
            $this->Insured = 'غير';
        }
        //return $earnings;
        $this->earArr = $earningsItems;
        $this->totalAcc = $totalAccruals;
        $deductions = $salaryJson['deductions'];
        $i = 1;
        $deductionsItems = array();
        $deductionsItems['ded1'] = 0.0;
        $deductionsItems['ded2'] = 0.0;
        $deductionsItems['TDS'] = 0.0;
        if (sizeof($deductions) > 0) {
            foreach ($deductions as $key => $value) {
                if ($key == 'TDS') {
                    $deductionsItems['TDS'] = $value;
                } else {
                    $deductionsItems['ded' . $i] = $value;
                }
                $i++;
            }
        }
        $deductionsItems['TotalDeductions'] = round($deductionsItems['TDS'] + $deductionsItems['ded1'] + $deductionsItems['ded2'] + $totOtherDiff, 2);
        $this->deductionsArr = $deductionsItems;
        $this->Net = $this->salarySlip->net_salary;
        $this->arabicTitle = __('payroll::modules.mon' . $this->salarySlip->month) . ' ' . $this->enToAr($this->salarySlip->year);
        $this->diffFromOrg = $totOtherDiff;
        /////////
        $documentFileName = 'employeeSlip.pdf';
        $view = View::make('payroll::payroll.pdfview', $this->data);
        $html_content = $view->render();

        $pdf = App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        //        $pdf->SetFont('aefurat', '', 10);
//        if (App::isLocale('ar')) {
//            $pdf->setRTL(true);
//        }
        $pdf->SetTitle('Report');
        $pdf->AddPage();
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);

        ////////////




        //        $pdf = app('dompdf.wrapper');
//        $pdf->loadView('payroll::payroll.pdfview', $this->data);
//        //   return $pdf->stream();
//        return $pdf->download($this->salarySlip->user->employeeDetail->employee_id . '-' . date('F', mktime(0, 0, 0, $this->salarySlip->month, 10)) . "-" . $this->salarySlip->year . '.pdf');
    }
}