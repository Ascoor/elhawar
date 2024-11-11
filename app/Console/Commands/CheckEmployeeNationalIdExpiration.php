<?php

namespace App\Console\Commands;

use App\EmployeeDetails;
use App\Notifications\EmployeeNationalIdExpiration;
use App\Notifications\EmployeeNationalIdExpirationCustomDB;
use App\Notifications\EmployeeNationalIdExpirationMail;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use SebastianBergmann\Environment\Console;

class CheckEmployeeNationalIdExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-employee-national-id-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check employee national id expiration';

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
       $employees = EmployeeDetails::all();
       $today = Carbon::now()->format('Y-m-d');
       //$msg = '';
       if ($employees) {
           foreach ($employees as $employee)
           {
                    if($today== $employee->expiration_date) {
                        $user = User::find($employee->user_id);
                        if ($user) {
                            //$msg='For user Id : '.$user->id.' Rowexpiratiodate : '.$employee->expiration_date.' : Today :'.$today;
                            $user->notify(new EmployeeNationalIdExpirationCustomDb());
                            $user->notify(new EmployeeNationalIdExpirationMail());
                        }
                        
                    }else{
                    //$msg = 'not send';
                    }
                    //\Log::info($msg);
           }
       }
        // \Log::info('ok from employee');
    }
}
