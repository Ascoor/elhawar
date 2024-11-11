<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\UpdateExchangeRates::class,
        Commands\AutoStopTimer::class,
        Commands\LicenceExpire::class,
        Commands\checkPaypalPlan::class,
        Commands\HideCoreJobMessage::class,
        Commands\SendProjectReminder::class,
        Commands\SendInvoiceReminder::class,
        Commands\SetStorageLimitExistingCompanies::class,
        Commands\AutoCreateRecurringInvoices::class,
        Commands\AddFineToUnpaidMembershipDue::class,
        Commands\AddFineToUnpaidMembershipYearly::class,
        Commands\FreeLicenceRenew::class,
        Commands\AutoCreateRecurringExpenses::class,
        Commands\SendAttendanceReminder::class,
        Commands\CheckNumberOfProducts::class,
        Commands\CheckEmployeeNationalIdExpiration::class,
        Commands\EmployeeContinuousAbsence::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {////cccccc
        // $schedule->call(function(){
        //     $fp=filemtime (__DIR__.DIRECTORY_SEPARATOR.'Kernel.php');
        //     info($fp);
        // })->everyMinute();
        $schedule->command('auto-stop-timer')->daily();
        $schedule->command('licence-expire')->daily();
        $schedule->command('check-paypal-plan')->everyThirtyMinutes();
        $schedule->command('hide-cron-message')->everyMinute();
        $schedule->command('send-project-reminder')->daily();
        $schedule->command('free-licence-renew')->daily();
        $schedule->command('recurring-invoice-create')->daily();
        $schedule->command('recurring-expenses-create')->daily();
        $schedule->command('recurring-invoice-add-fin-due')->yearlyOn(11, 1, '1:00'); //Run the task every year on Nov 1st at 1:00
        $schedule->command('recurring-invoice-add-fin-yearly')->yearlyOn(7, 1, '1:00'); //Run the task every year on Jul 1st at 1:00
        $schedule->command('send-invoice-reminder')->daily();
        $schedule->command('send-attendance-reminder')->everyMinute();
        $schedule->command('check-number-of-products')->everyMinute();
        $schedule->command('check-employee-national-id-expiration')->monthly();
        $schedule->command('employee-continuous-absence')->daily();


    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
