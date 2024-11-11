<?php

namespace App\Http\Controllers\Club;

use App\Currency;
use App\DataTables\Admin\FamilyDatatTable;
use App\DataTables\Club\FamilyMembersDataTable;
use App\DataTables\Admin\ViewMemberDataTable;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Invoice;
use App\InvoiceItems;
use App\Level;
use App\Location;
use App\memberCategory;
use App\memberDetails;
use App\memberRelations;
use App\memberStatus;
use App\Notifications\NewInvoice;
use App\PlayerGroup;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use App\TripMember;
use App\Trips;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClubTripController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'app.menu.trips_calender';
        $this->pageIcon = 'icon-calender';
    }
    public function index()
    {
        $this->currencies=Currency::all();
        $this->trips=Trips::all();
        $this->supervisors=EmployeeDetails::where('designation_id' , 1)->get();

        return view('club.trips.trips_calender', $this->data );
    }
    public function show($id){
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $member=memberDetails::where('user_id' , auth()->user()->id)->first();
        $this->members=$member->family();

        $this->trip=Trips::where('id',$id)->first();
        $this->supervisor=EmployeeDetails::where('user_id' ,$this->trip->supervisor_id )->first();

        $subscribedSessions=TripMember::where('trip_id' , $id)->get();
        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $i++;
        }
        $this->subscribers=$subscribers;





        return view('club.trips.show_trip', $this->data);
    }
    public function mySessions(){
        $this->currencies=Currency::all();
        $this->trips=Trips::all();
        $this->supervisors=EmployeeDetails::where('designation_id' , 1)->get();

        return view('club.trips.my_trips', $this->data );
    }
    public function subscribe(Request $request ,$id){




        $subscribedSessions=TripMember::where('trip_id' , $id)->get();
        $sportSession=Trips::where('id' , $id)->first();
        $user_id= $request->input('user_id') ? $request->input('user_id') : auth()->user()->id;
        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $i++;
        }

        $user =  \Auth::user();





        if (!in_array($user_id,$subscribers )) {
            if ($sportSession->available != 0) {
                $invoice = new Invoice();
                $invoice->project_id = $request->project_id ?? null;
                $invoice->client_id = $user->id;
                $invoice->invoice_number = Invoice::lastInvoiceNumber() + 1;
                $invoice->issue_date = Carbon::now();
                $invoice->due_date = Carbon::now();
                $invoice->sub_total = round($sportSession->member_fees, 2);
                $invoice->discount = 0;
                $invoice->discount_type = 'percent';
                $invoice->total = round($sportSession->member_fees, 2);
                $invoice->currency_id = Currency::where('currency_code',$sportSession->currency)->first()->id;
                $invoice->recurring = 'no';
                $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
                $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
                $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
                $invoice->note = $request->note;
                $invoice->show_shipping_address = 'no';
                $invoice->created_by = $user->id;
                $invoice->save();
                InvoiceItems::create(
                    [
                        'invoice_id' => $invoice->id,
                        'item_name' => $sportSession->trip_name.' #'.$sportSession->id,
                        'item_summary' => '',
                        'hsn_sac_code' =>  null,
                        'type' => 'item',
                        'quantity' => 1.00,
                        'unit_price' => round($sportSession->member_fees, 2),
                        'amount' => round($sportSession->member_fees, 2),
                        'taxes' =>null
                    ]
                );
                $notifyUser = $invoice->client;
                if (!is_null($notifyUser)) {
                    $notifyUser->notify(new NewInvoice($invoice));
                }

                $invoice->send_status = 1;
                $invoice->save();
                    $subscribe = new TripMember();
                    $subscribe->user_id = $user_id;
                    $subscribe->trip_id = $id;
                    $sportSession->available--;
                    $subscribe->save();
                    $sportSession->save();
                return Reply::success(__('messages.subsribtion_done'));
            } else {
                return Reply::error('Sorry! Not available ');
            }
        }
        else{
            return Reply::error('This user is already subscribed in this session!');

        }

    }
    public function sportEventFilter(Request $request){
        $trip=Trips::select('*');

        if (request()->has('trip') && $request->trip != 0) {
            $trip->where('id',  $request->trip);
        }
        if (request()->has('supervisor') && $request->supervisor != 0) {
            $trip->where('supervisor_id',  $request->supervisor);
        }
        if (request()->has('group') && $request->group != 0) {
            $trip->where('group_id',  $request->group);
        }
        if (request()->has('coach') && $request->coach != 0) {
            $trip->where('coach_id',  $request->coach);
        }
        if (request()->has('location_id') && $request->location_id != 0) {
            $trip->where('location_id',  $request->location_id);
        }
        $trip = $trip->where('start_date_time' , '>' , Carbon::now())->get();

        $taskEvents = array();
        foreach ($trip as $key => $value) {
            if($value->repeat=="yes"){

                if ($value->repeat_type == 'day') {
                    $freq = 'DAILY';
                } else if ($value->repeat_type == 'week') {
                    $freq = 'WEEKLY';
                } else if ($value->repeat_type == 'month') {
                    $freq = 'MONTHLY';
                } else if ($value->repeat_type == 'year') {
                    $freq = 'YEARLY';
                }
                //     $arr =[];
                //    $rule = 'DTSTART:DATE\nRRULE:FREQ=MONTHLY;COUNT=6;INTERVAL=1';
                //    $search  = array("DATE","MONTHLY","6","1 ");
                //    $replace = array($value->start_date_time,$freq,$value->repeat_cycles,$value->repeat_every);
                //    $output = str_replace($search, $replace, $rule);


                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->trip_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            }else{
                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->trip_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time
                ];
            }

        }
        return $taskEvents;
    }
    public function mySportEventFilter(Request $request){
        $subscribedSessions=TripMember::where('user_id' , auth()->user()->id)->get();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribedIds[$i]=$session->trip_id;
            $i++;
        }
        $trip=Trips::select('*');

        if (request()->has('trip') && $request->trip != 0) {
            $trip->where('id',  $request->trip);
        }
        if (request()->has('supervisor') && $request->supervisor != 0) {
            $trip->where('supervisor_id',  $request->supervisor);
        }

        $trip = $trip->whereIn('id' , $subscribedIds)->get();
        $taskEvents = array();
        foreach ($trip as $key => $value) {
            if($value->repeat=="yes"){

                if ($value->repeat_type == 'day') {
                    $freq = 'DAILY';
                } else if ($value->repeat_type == 'week') {
                    $freq = 'WEEKLY';
                } else if ($value->repeat_type == 'month') {
                    $freq = 'MONTHLY';
                } else if ($value->repeat_type == 'year') {
                    $freq = 'YEARLY';
                }
                //     $arr =[];
                //    $rule = 'DTSTART:DATE\nRRULE:FREQ=MONTHLY;COUNT=6;INTERVAL=1';
                //    $search  = array("DATE","MONTHLY","6","1 ");
                //    $replace = array($value->start_date_time,$freq,$value->repeat_cycles,$value->repeat_every);
                //    $output = str_replace($search, $replace, $rule);


                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->trip_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            }else{
                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->trip_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time
                ];
            }

        }
        return $taskEvents;
    }

    public function familySessions(){
        $this->currencies=Currency::all();
        $this->trips=Trips::all();
        $this->supervisors=EmployeeDetails::where('designation_id' , 1)->get();

        return view('club.trips.family_trips', $this->data );
    }

    public function familySportEventFilter(Request $request){
        $sportSession=Trips::select('*');
        $j=0;
//        $familyMember_ids=array();
//        $subscribedIds=array();
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familyMembers=memberDetails::where('family_id' ,$member->family_id )->where('user_id' , '!=' , auth()->user()->id)->get();
        foreach ($familyMembers as $familyMember){
            $familyMember_ids[$j]=$familyMember->user_id;
            $j++;
        }
        $subscribedSessions=TripMember::whereIn('user_id' , $familyMember_ids)->get();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribedIds[$i]=$session->trip_id;
            $i++;
        }
        if (request()->has('trip') && $request->trip != 0) {
            $sportSession->where('id',  $request->trip);
        }
        if (request()->has('supervisor') && $request->supervisor != 0) {
            $sportSession->where('supervisor_id',  $request->supervisor);
        }
        $sportSession = $sportSession->whereIn('id' , $subscribedIds)->get();

        $taskEvents = array();
        foreach ($sportSession as $key => $value) {
            foreach ($familyMembers as $familyMember) {
                if (TripMember::where('trip_id', $value->id)->where('user_id', $familyMember->user_id)->first()) {

                    if ($value->repeat == "yes") {

                        if ($value->repeat_type == 'day') {
                            $freq = 'DAILY';
                        } else if ($value->repeat_type == 'week') {
                            $freq = 'WEEKLY';
                        } else if ($value->repeat_type == 'month') {
                            $freq = 'MONTHLY';
                        } else if ($value->repeat_type == 'year') {
                            $freq = 'YEARLY';
                        }
                        //     $arr =[];
                        //    $rule = 'DTSTART:DATE\nRRULE:FREQ=MONTHLY;COUNT=6;INTERVAL=1';
                        //    $search  = array("DATE","MONTHLY","6","1 ");
                        //    $replace = array($value->start_date_time,$freq,$value->repeat_cycles,$value->repeat_every);
                        //    $output = str_replace($search, $replace, $rule);


                        $taskEvents[] = [
                            'id' => $value->id,
                            'title' => $familyMember->name." : ".$value->trip_name,
                            'className' => $value->label_color,
                            'start' => $value->start_date_time,
                            'end' => $value->end_date_time,

                        ];
                    } else {
                        $taskEvents[] = [
                            'id' => $value->id,
                            'title' => $familyMember->name." : ".$value->trip_name,
                            'className' => $value->label_color,
                            'start' => $value->start_date_time,
                            'end' => $value->end_date_time
                        ];
                    }
                }
            }
        }
        return $taskEvents;
    }

}