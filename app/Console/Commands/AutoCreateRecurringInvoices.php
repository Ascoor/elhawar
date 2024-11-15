<?php

namespace App\Console\Commands;

use App\Company;
use App\Invoice;
use App\InvoiceItems;
use App\Notifications\NewInvoiceRecurring;
use App\RecurringInvoice;
use App\Scopes\CompanyScope;
use App\UniversalSearch;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoCreateRecurringInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring-invoice-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto create recurring invoices ';

    /**
     * AutoCreateRecurringInvoices constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $companies = Company::all();
        foreach($companies as $company) {
            $recurringInvoices = RecurringInvoice::with(['recurrings', 'items'])
                ->where('status', 'active')
                ->where('company_id', $company->id)
                ->get();

            $recurringInvoices->each(function ($recurring) use($company) {

                if ($recurring->unlimited_recurring == 1 || ($recurring->unlimited_recurring == 0 && $recurring->recurrings->count() < $recurring->billing_cycle)) {

                    // Why type of date is today
                    $today = Carbon::now()->timezone($company->timezone);
                    //$today = Carbon::parse('2022-7-1');
                    $isMonthly = ($today->day === $recurring->day_of_month);
                    $isWeekly = ($today->dayOfWeek === $recurring->day_of_week);
                    $isBiWeekly = ($isWeekly && $today->weekOfYear % 2 === 0);
                    $isQuarterly = ($isMonthly && $today->month % 3 === 1);
                    $isHalfYearly = ($isMonthly && $today->month % 6 === 1);
                    //$isAnnually = ($isMonthly && $today->month % 12 === 1);
                    $isAnnually = ($isMonthly && $today->month % 12 === 7);
                    if ($recurring->rotation === 'daily' ||
                        ($recurring->rotation === 'weekly' && $isWeekly) ||
                        ($recurring->rotation === 'bi-weekly' && $isBiWeekly) ||
                        ($recurring->rotation === 'monthly' && $isMonthly) ||
                        ($recurring->rotation === 'quarterly' && $isQuarterly) ||
                        ($recurring->rotation === 'half-yearly' && $isHalfYearly) ||
                        ($recurring->rotation === 'annually' && $isAnnually)
                    ) {
                        $this->invoiceCreate($recurring, $company->id, $count=$recurring->recurrings->count());
                        //print_r($recurring->recurrings->count());
                    }
                }

            });
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function invoiceCreate($invoiceData, $companyID, $count)
    {
        $recurring = $invoiceData;
        $formatedDueDate= $recurring->due_date;
        $formatedIssueDate= $recurring->issue_date;

        //$currentDate = Carbon::now();
        $currentDate = Carbon::parse('2022-7-1');

        //$dueDate = $currentDate->addDays($diff)->format('Y-m-d');


        if ($recurring->rotation === 'daily'){
            $dueDate =$formatedDueDate->addDays($count);
            $issueDate = $formatedIssueDate->addDays($count);
        }
        elseif($recurring->rotation === 'weekly'){
            $dueDate =$formatedDueDate->addDays($count*7);
            $issueDate = $formatedIssueDate->addDays($count*7);
        }
        elseif($recurring->rotation === 'bi-weekly'){
            $dueDate =$formatedDueDate->addDays($count*14);
            $issueDate = $formatedIssueDate->addDays($count*14);
        }
        elseif($recurring->rotation === 'monthly'){
            $dueDate =$formatedDueDate->addMonths($count);
            $issueDate = $formatedIssueDate->addMonths($count);
        }
        elseif($recurring->rotation === 'quarterly'){
            $dueDate =$formatedDueDate->addMonths($count*3);
            $issueDate = $formatedIssueDate->addMonths($count*3);
        }
        elseif($recurring->rotation === 'half-yearly'){
            $dueDate =$formatedDueDate->addMonths($count*6);
            $issueDate = $formatedIssueDate->addMonths($count*6);
        }
        elseif($recurring->rotation == 'annually'){
            $dueDate =$formatedDueDate->addYears($count);
            $issueDate = $formatedIssueDate->addYears($count);
        }

        //print_r($count);
        if($recurring->is_renew == 1){
        $issDate=Carbon::parse($formatedIssueDate);
        // check if first time register for late payments by checking count
            if(($currentDate->year > $issDate->year) && ($count==0)){
                $cnt=$currentDate->year - $issDate->year;
                //print_r('here');
                for($i=0; $i<=$cnt ;$i++){
                    if($i>0){
                        $dueDate =$formatedDueDate->addYears(1);
                        $issueDate = $formatedIssueDate->addYears(1);
                    }

                    $invoice = new Invoice();
                    $invoice->invoice_recurring_id  = $recurring->id;
                    $invoice->company_id            = $companyID;
                    $invoice->project_id            = $recurring->project_id ?? null;
                    $invoice->client_id             = $recurring->project_id == '' && $recurring->client_id ? $recurring->client_id : null;
                    $invoice->invoice_number        = $this->lastInvoiceNumber($companyID) + 1;

                    $invoice->issue_date            = $issueDate->format('Y-m-d');
                    $invoice->due_date              = $dueDate->format('Y-m-d');

                    $invoice->sub_total             = round($recurring->sub_total, 2);
                    $invoice->discount              = round($recurring->discount_value, 2);
                    $invoice->discount_type         = $recurring->discount_type;
                    $invoice->total                 = round($recurring->total, 2);
                    $invoice->currency_id           = $recurring->currency_id;
                    $invoice->note                  = $recurring->note;
                    $invoice->show_shipping_address = $recurring->show_shipping_address;
                    $invoice->send_status           = 1;
                    $invoice->save();

                    if ($invoice->shipping_address) {
                        if ($invoice->project_id != null && $invoice->project_id != '') {
                            $client = $invoice->project->clientdetails;
                        } elseif ($invoice->client_id != null && $invoice->client_id != '') {
                            $client = $invoice->clientdetails;
                        }

                        $client->shipping_address = $invoice->shipping_address;

                        $client->save();
                    }

                    foreach ($invoiceData->items as $key => $item) :
                        InvoiceItems::create(
                            [
                                'invoice_id'   => $invoice->id,
                                'item_name'    => $item->item_name,
                                'item_summary' => $item->item_summary,
                                'hsn_sac_code' => (isset($item->hsn_sac_code)) ? $item->hsn_sac_code : null ,
                                'type'         => 'item',
                                'quantity'     => $item->quantity,
                                'unit_price'   => $item->unit_price,
                                'amount'       => $item->amount,
                                'taxes'        => $item->taxes
                            ]
                        );
                    endforeach;

                    if (($invoice->project && $invoice->project->client_id != null) || $invoice->client_id != null) {
                        $clientId = ($invoice->project && $invoice->project->client_id != null) ? $invoice->project->client_id : $invoice->client_id;
                        // Notify client
                        $notifyUser = User::withoutGlobalScopes([CompanyScope::class, 'active'])->findOrFail($clientId);

                        $notifyUser->notify(new NewInvoiceRecurring($invoice));
                    }

                    //log search
                    $this->logSearchEntry($invoice->id, 'Invoice ' . $invoice->invoice_number, 'admin.all-invoices.show', 'invoice', $companyID);

                }
            }
            else{
            //print_r('here2');
            $invoice = new Invoice();
            $invoice->invoice_recurring_id  = $recurring->id;
            $invoice->company_id            = $companyID;
            $invoice->project_id            = $recurring->project_id ?? null;
            $invoice->client_id             = $recurring->project_id == '' && $recurring->client_id ? $recurring->client_id : null;
            $invoice->invoice_number        = $this->lastInvoiceNumber($companyID) + 1;

            $invoice->issue_date            = $issueDate->format('Y-m-d');
            $invoice->due_date              = $dueDate->format('Y-m-d');

            $invoice->sub_total             = round($recurring->sub_total, 2);
            $invoice->discount              = round($recurring->discount_value, 2);
            $invoice->discount_type         = $recurring->discount_type;
            $invoice->total                 = round($recurring->total, 2);
            $invoice->currency_id           = $recurring->currency_id;
            $invoice->note                  = $recurring->note;
            $invoice->show_shipping_address = $recurring->show_shipping_address;
            $invoice->send_status           = 1;
            $invoice->save();

            if ($invoice->shipping_address) {
                if ($invoice->project_id != null && $invoice->project_id != '') {
                    $client = $invoice->project->clientdetails;
                } elseif ($invoice->client_id != null && $invoice->client_id != '') {
                    $client = $invoice->clientdetails;
                }

                $client->shipping_address = $invoice->shipping_address;

                $client->save();
            }

            foreach ($invoiceData->items as $key => $item) :
                InvoiceItems::create(
                    [
                        'invoice_id'   => $invoice->id,
                        'item_name'    => $item->item_name,
                        'item_summary' => $item->item_summary,
                        'hsn_sac_code' => (isset($item->hsn_sac_code)) ? $item->hsn_sac_code : null ,
                        'type'         => 'item',
                        'quantity'     => $item->quantity,
                        'unit_price'   => $item->unit_price,
                        'amount'       => $item->amount,
                        'taxes'        => $item->taxes
                    ]
                );
            endforeach;

            if (($invoice->project && $invoice->project->client_id != null) || $invoice->client_id != null) {
                $clientId = ($invoice->project && $invoice->project->client_id != null) ? $invoice->project->client_id : $invoice->client_id;
                // Notify client
                $notifyUser = User::withoutGlobalScopes([CompanyScope::class, 'active'])->findOrFail($clientId);

                $notifyUser->notify(new NewInvoiceRecurring($invoice));
            }

            //log search
            $this->logSearchEntry($invoice->id, 'Invoice ' . $invoice->invoice_number, 'admin.all-invoices.show', 'invoice', $companyID);

        }
        }else{
            //print_r('here3');
        $invoice = new Invoice();
        $invoice->invoice_recurring_id  = $recurring->id;
        $invoice->company_id            = $companyID;
        $invoice->project_id            = $recurring->project_id ?? null;
        $invoice->client_id             = $recurring->project_id == '' && $recurring->client_id ? $recurring->client_id : null;
        $invoice->invoice_number        = $this->lastInvoiceNumber($companyID) + 1;

        $invoice->issue_date            = $issueDate->format('Y-m-d');
        $invoice->due_date              = $dueDate->format('Y-m-d');

        $invoice->sub_total             = round($recurring->sub_total, 2);
        $invoice->discount              = round($recurring->discount_value, 2);
        $invoice->discount_type         = $recurring->discount_type;
        $invoice->total                 = round($recurring->total, 2);
        $invoice->currency_id           = $recurring->currency_id;
        $invoice->note                  = $recurring->note;
        $invoice->show_shipping_address = $recurring->show_shipping_address;
        $invoice->send_status           = 1;
        $invoice->save();

        if ($invoice->shipping_address) {
            if ($invoice->project_id != null && $invoice->project_id != '') {
                $client = $invoice->project->clientdetails;
            } elseif ($invoice->client_id != null && $invoice->client_id != '') {
                $client = $invoice->clientdetails;
            }

            $client->shipping_address = $invoice->shipping_address;

            $client->save();
        }

        foreach ($invoiceData->items as $key => $item) :
            InvoiceItems::create(
                [
                    'invoice_id'   => $invoice->id,
                    'item_name'    => $item->item_name,
                    'item_summary' => $item->item_summary,
                    'hsn_sac_code' => (isset($item->hsn_sac_code)) ? $item->hsn_sac_code : null ,
                    'type'         => 'item',
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'amount'       => $item->amount,
                    'taxes'        => $item->taxes
                ]
            );
        endforeach;

        if (($invoice->project && $invoice->project->client_id != null) || $invoice->client_id != null) {
            $clientId = ($invoice->project && $invoice->project->client_id != null) ? $invoice->project->client_id : $invoice->client_id;
            // Notify client
            $notifyUser = User::withoutGlobalScopes([CompanyScope::class, 'active'])->findOrFail($clientId);

            $notifyUser->notify(new NewInvoiceRecurring($invoice));
        }

        //log search
        $this->logSearchEntry($invoice->id, 'Invoice ' . $invoice->invoice_number, 'admin.all-invoices.show', 'invoice', $companyID);

    }


    }

//    public function client_detail()
//    {
//        return $this->hasOne(ClientDetails::class, 'user_id')
//            ->where('client_details.company_id', company()->id);
//    }

    /**
     * @param $searchableId
     * @param $title
     * @param $route
     * @param $type
     * @param $companyID
     */
    public function logSearchEntry($searchableId, $title, $route, $type, $companyID)
    {
        $search = new UniversalSearch();
        $search->searchable_id = $searchableId;
        $search->title = $title;
        $search->route_name = $route;
        $search->module_type = $type;
        $search->company_id = $companyID;
        $search->save();
    }

    /**
     * @param $companyID
     * @return mixed
     */
    public static function lastInvoiceNumber($companyID)
    {
        $invoice = DB::select('SELECT MAX(CAST(`invoice_number` as UNSIGNED)) as invoice_number FROM `invoices` where company_id = "' . $companyID . '"');
        return $invoice[0]->invoice_number;
    }
}
