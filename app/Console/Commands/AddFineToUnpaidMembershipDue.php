<?php

namespace App\Console\Commands;

use App\Company;
use App\Invoice;
use App\InvoiceItems;
use App\memberDetails;
use App\Notifications\UnPaidDropMembershipAdminAlert;
use App\Observers\InvoiceRecurringObserver;
use App\RecurringInvoice;
use App\RecurringInvoiceItems;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddFineToUnpaidMembershipDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring-invoice-add-fin-due';

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
        //$now = Carbon::now();
        $now = Carbon::parse('2022-11-1');
        $recurringInvoices = RecurringInvoice::with(['recurrings', 'items'])
            ->join('invoices', 'invoices.invoice_recurring_id', '=', 'invoice_recurring.id')
            ->where('invoice_recurring.status', 'active')
            ->where('invoice_recurring.is_renew', 1)
            ->where('invoices.due_date','<',$now)
            ->where('invoices.status', 'unpaid')->get();

        foreach ($recurringInvoices as $singleRecurringInvoices)
        {
            $unit_price = RecurringInvoiceItems::where('is_main_membership_item',1)
                ->where('invoice_recurring_id',$singleRecurringInvoices->invoice_recurring_id)
                ->first()->unit_price;
            if($unit_price){
                $issue=$singleRecurringInvoices->issue_date;
                $date = Carbon::parse($issue);
                $diff = $date->diffInMonths($now);

                if ($diff < 11) {
                        $fine = round($unit_price * 0.25, 2);
                        $item_name = 'غرامة تاخير استحقاق';
                        $item_summary = 'غرامة تاخير استحقاق';

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
                    $temp=0;
                    $inv = Invoice::findOrFail($singleRecurringInvoices->id);
                    foreach ($inv->items as $invItem){
                        $temp += $invItem->unit_price;
                    }

                    $inv->sub_total = round( $temp, 2);
                    $inv->total = round( $temp, 2);
                    $inv->save();
                }elseif($diff>47 && $diff<56){
                    $user = User::find('name','Admin');
                    $member=MemberDetails::where('user_id',$singleRecurringInvoices->client_id)->first();
                    if ($user) {
                        $user->notify(new UnPaidDropMembershipAdminAlert($member));
                    }
                }

            }

        }

    }
}
