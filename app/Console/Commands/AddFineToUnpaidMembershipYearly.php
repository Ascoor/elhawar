<?php

namespace App\Console\Commands;

use App\Company;
use App\Invoice;
use App\InvoiceItems;
use App\Notifications\UnPaidDropMembershipMemberAlert;
use App\Observers\InvoiceRecurringObserver;
use App\RecurringInvoice;
use App\RecurringInvoiceItems;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddFineToUnpaidMembershipYearly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring-invoice-add-fin-yearly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $now = Carbon::now();
        //$now = Carbon::parse('2022-7-1');
        $finedate=$now->subMonths(11);
        $recurringInvoices = RecurringInvoice::with(['recurrings', 'items'])
            ->join('invoices', 'invoices.invoice_recurring_id', '=', 'invoice_recurring.id')
            ->where('invoice_recurring.status', 'active')
            ->where('invoice_recurring.is_renew', 1)
            ->where('invoices.issue_date','<=',$finedate)
            ->where('invoices.status', 'unpaid')->get();

        foreach ($recurringInvoices as $singleRecurringInvoices)
        {
            $now = Carbon::now();
            //$now = Carbon::parse('2022-7-1');
            $unit_price = RecurringInvoiceItems::where('is_main_membership_item',1)
                ->where('invoice_recurring_id',$singleRecurringInvoices->invoice_recurring_id)
                ->first()->unit_price;
            if($unit_price){
                $issue=$singleRecurringInvoices->issue_date;

                $date = Carbon::parse($issue);
                $diff = $now->diffInMonths($date);
                    if ($diff >= 47) {
                        $fine = round($unit_price * 3.0, 2);
                        $item_name = 'غرامة تاخير 4 اعوام فاكثر';
                        $item_summary = 'غرامة تاخير 4 اعوام فاكثر';
                        $user = User::find($singleRecurringInvoices->client_id);
                        if ($user) {
                            $user->notify(new UnPaidDropMembershipMemberAlert());

                        }

                    } elseif ($diff >= 35) {
                        $fine = round($unit_price * 2.0, 2);
                        $item_name = 'غرامة تاخير 3 اعوام ';
                        $item_summary = 'غرامة تاخير 3 اعوام ';
                    } elseif ($diff >= 23) {
                        $fine = round($unit_price * 1.0, 2);
                        $item_name = 'غرامة تاخيرعامين';
                        $item_summary = 'غرامة تاخيرعامين';
                    } else {
                        $fine = round($unit_price * 0.5, 2);
                        $item_name = 'غرامة تاخير عام';
                        $item_summary = 'غرامة تاخير عام';
                    }
                    $fineInvItem = InvoiceItems::where('invoice_id', $singleRecurringInvoices->id)
                        ->where('is_fine', 1)->first();
                    if ($fineInvItem) {
                        $fineInvItem->unit_price = $fine;
                        $fineInvItem->item_name = $item_name;
                        $fineInvItem->item_summary = $item_summary;
                        $fineInvItem->amount = $fine;
                        $fineInvItem->save();

                    } else {
                        InvoiceItems::create(
                            [
                                'invoice_id' => $singleRecurringInvoices->id,
                                'is_fine' => 1,
                                'item_name' => $item_name,
                                'item_summary' => $item_summary,
                                'hsn_sac_code' => null,
                                'type' => 'item',
                                'quantity' => 1,
                                'unit_price' => $fine,
                                'amount' => $fine,
                                'taxes' => null
                            ]);
                    }
                    //update invoice recurring adding this item in recurring will cause duplication in main auto recurring cron job
//                    $recItem = RecurringInvoice::findOrFail($singleRecurringInvoices->invoice_recurring_id);
//                    $recItem->sub_total = round($recItem->sub_total +$fine,2);
//                    $recItem->total = round($recItem->total +$fine,2);
//                    $recItem->save();
                    //update invoice
                    $temp=0;
                    $inv = Invoice::findOrFail($singleRecurringInvoices->id);
                    foreach ($inv->items as $invItem){
                        $temp += $invItem->unit_price;
                    }

                    $inv->sub_total = round( $temp, 2);
                    $inv->total = round( $temp, 2);
                    $inv->save();

            }

        }

    }
}
