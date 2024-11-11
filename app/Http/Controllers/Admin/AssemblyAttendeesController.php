<?php

namespace App\Http\Controllers\Admin;

use App\AssemblyAttendees;
use App\ClientSubCategory;
use App\ContractType;
use App\Country;
use App\Currency;
use App\DataTables\Admin\AssemblyAttendeesDataTable;
use App\GeneralAssembly;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItems;
use App\memberCategory;
use App\memberDetails;
use App\memberStatus;
use App\Notifications\NewInvoice;
use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssemblyAttendeesController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.general_assembly';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }



    public function attendanceIndex(AssemblyAttendeesDataTable $dataTable , $assembly_id){
        abort_if(!$this->user->cans('view_members'),403);
        $this->assembly_id=$assembly_id;
        $now = Carbon::now();
        $oneYearBack=$now->subYears(1)->format('Y-m-d');
        $this->members = memberDetails::where('category_id','=',1)
            ->where('renewal_status','=','renewed')
            // ->where('status_id',7)
            ->whereDate('date_of_subscription','<=',$oneYearBack)
            ->get();

        $this->status = MemberStatus::all();
        $this->totalmembers = count($this->members);
        $this->categories = memberCategory::all();
        $this->projects = Project::all();
        $this->contracts = ContractType::all();
        $this->countries = Country::all();
        $this->subcategories = ClientSubCategory::all();
        return $dataTable->render('admin.general-assembly.attendees_index', $this->data);
    }

    public function addAttendee($id , $assembly_id){
        abort_if(!$this->user->cans('edit_members'),403);
if (!AssemblyAttendees::where('user_id',$id)->where('assembly_id',$assembly_id)->first()){
        $attendee=new AssemblyAttendees();
        $attendee->assembly_id=$assembly_id;
        $attendee->user_id=$id;
        $attendee->save();
        return Reply::success(__('messages.attendeeAdded'));
} else{
    return Reply::error(__('messages.already_attendant'));
}

    }
    public function applyFine(Request $request,$assembly_id){
        abort_if(!$this->user->cans('edit_members'),403);
        $assembly=GeneralAssembly::find($assembly_id);
        $delay_fine=$assembly->delay_fine;

        $attendees=AssemblyAttendees::where('assembly_id',$assembly_id)->get();
        $i=0;
        foreach ($attendees as $attendee){
            $attendees_ids[$i]=$attendee->user_id;
            $i++;
        }
        if (collect(AssemblyAttendees::where('assembly_id',$assembly_id)->get())->count() == 0){
            $attendees_ids=array();
        }

        $members=memberDetails::where('category_id','=',1)->where('renewal_status','=','renewed')->get();
        foreach ($members as $member){
            $existInvoice=array();
            $j=0;
            $existInvoiceitems=InvoiceItems::where('item_name' ,$assembly->name . ' - ' . $assembly->start_date)->get();
                foreach ($existInvoiceitems as $existInvoiceitem) {
                    if (Invoice::where('id', $existInvoiceitem->invoice_id)->where('client_id', $member->user_id)->first()) {
                        $existInvoice[$j] = Invoice::where('id', $existInvoiceitem->invoice_id)->where('client_id', $member->user_id)->first();
                    }
                }
            if (count($existInvoice)==0) {
                if (!in_array($member->user_id, $attendees_ids)) {
                    $invoice = new Invoice();
                    $invoice->project_id = $request->project_id ?? null;
                    $invoice->client_id = $member->user_id;
                    $invoice->invoice_number = Invoice::lastInvoiceNumber() + 1;
                    $invoice->issue_date = Carbon::now();
                    $invoice->due_date = $assembly->start_date;
                    $invoice->sub_total = round($delay_fine, 2);
                    $invoice->discount = 0;
                    $invoice->discount_type = 'percent';
                    $invoice->total = round($delay_fine, 2);
                    $invoice->currency_id = Currency::where('currency_code', $assembly->currency)->first()->id;
                    $invoice->recurring = 'no';
                    $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
                    $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
                    $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
                    $invoice->note = $request->note;
                    $invoice->show_shipping_address = 'no';
                    $invoice->created_by = auth()->user()->id;
                    $invoice->save();
                    InvoiceItems::create(
                        [
                            'invoice_id' => $invoice->id,
                            'item_name' => $assembly->name . ' - ' . $assembly->start_date,
                            'item_summary' => '',
                            'hsn_sac_code' => null,
                            'type' => 'item',
                            'quantity' => 1.00,
                            'unit_price' => round($delay_fine, 2),
                            'amount' => round($delay_fine, 2),
                            'taxes' => null
                        ]
                    );
                    $notifyUser = $invoice->client;
                    if (!is_null($notifyUser)) {
                        $notifyUser->notify(new NewInvoice($invoice));
                    }

                    $invoice->send_status = 1;
                    $invoice->save();

                }

            }
        }
        return Reply::success(__('messages.fine_applied'));
    }

}
