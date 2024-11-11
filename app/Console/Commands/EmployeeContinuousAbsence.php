<?php

namespace App\Console\Commands;

use App\Attendance;
use App\EmployeeDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class EmployeeContinuousAbsence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee-continuous-absence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification for Employee That makes Countionus Absence';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $daysOfAllowedAbsence=15;
       $employees = EmployeeDetails::all();
       $today = Carbon::now();
       $dayToJudge = Carbon::now()->subDays($daysOfAllowedAbsence);
        if($dayToJudge->day<10)
        {
            $Jd='0'.$dayToJudge->day.'-';
        }else{
            $Jd=$dayToJudge->day.'-';
        }
        if($today->day<10)
        {
            $d='0'.$today->day.'-';
        }else{
            $d=$today->day.'-';
        }
        $startDate = Carbon::parse(Carbon::parse( $Jd. $dayToJudge->month. '-' . $dayToJudge->year));
        $endDate = Carbon::parse(Carbon::parse($d . $today->month . '-' . $today->year));
       $msg = '';
       if ($employees) {
           foreach ($employees as $employee)
           {
               $presentCount = Attendance::countDaysPresentByUser($startDate, $endDate, $employee->user_id);
                    if($presentCount < 1) {
                        $user = User::find($employee->user_id);
                        if ($user) {
                            $msg='For user Id : '.$user->id.' send notification';
                            //$user->notify(new EmployeeNationalIdExpiration());
                        }
                        
                    }else{
                    $msg = $msg='For user Id : '.$user->id.' do not send notification';
                    }
                    \Log::info($msg);
           }
       }
        // \Log::info('ok from employee');
    }
}
