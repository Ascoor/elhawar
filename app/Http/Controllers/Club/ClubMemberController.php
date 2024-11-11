<?php

namespace App\Http\Controllers\Club;

use App\Attendance;
use App\AttendanceSetting;
use App\Currency;
use App\DataTables\Admin\FamilyDatatTable;
use App\DataTables\Club\FamilyMembersDataTable;
use App\DataTables\Admin\ViewMemberDataTable;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Holiday;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Invoice;
use App\InvoiceItems;
use App\Leave;
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
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClubMemberController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'app.menu.sessions_calender';
        $this->pageIcon = 'icon-calender';

        $this->attendanceSettings = AttendanceSetting::first();

        //Getting Maximum Check-ins in a day
        $this->maxAttandenceInDay = $this->attendanceSettings->clockin_in_day;
    }
    public function index()
    {
        $this->sports = SportAcademy::all();
        $this->currencies=Currency::all();
        $this->levels = Level::all();
        $this->groups = PlayerGroup::all();
        $this->locations = Location::all();
        $this->coaches=EmployeeDetails::where('designation_id' , 1)->get();

        return view('club.sports_calender', $this->data );
    }
    public function show($id){
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->session=SportSession::where('id',$id)->first();
        $member=memberDetails::where('user_id' , auth()->user()->id)->first();
        $this->members=$member->family();
        $this->coach=EmployeeDetails::where('user_id' ,$this->session->coach_id )->first();
        $this->location=Location::where('id',$this->session->location_id)->first();
        $this->sport=SportAcademy::where('id',$this->session->sport_id)->first();
        $this->level=Level::where('id',$this->session->level_id)->first();
        $this->group=PlayerGroup::where('id',$this->session->group_id)->first();
        $subscribedSessions=SessionMember::where('session_id' , $this->session->session_id)->get();
        $subscribers=array();
        $i=0;
           foreach ($subscribedSessions as $session){
               $subscribers[$i]=$session->user_id;
               $i++;
           }
           $this->subscribers=$subscribers;





        return view('club.show_session', $this->data);
    }
    public function mySessions(){
        $this->sports = SportAcademy::all();
        $this->currencies=Currency::all();
        $this->levels = Level::all();
        $this->groups = PlayerGroup::all();
        $this->locations = Location::all();
        $this->coaches=EmployeeDetails::where('designation_id' , 1)->get();

        return view('club.index', $this->data );
    }
    public function subscribe(Request $request ,$id){
        $user =  \Auth::user();
        $sportSession=SportSession::where('id' , $id)->first();
        $relatedSessions=SportSession::where('session_id' ,$sportSession->session_id )->get();

        $subscribedSessions=SessionMember::where('session_id' , $sportSession->session_id)->get();
            $user_id = $request->input('user_id') ? $request->input('user_id') : auth()->user()->id;

        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $i++;
        }
    if (!in_array($user_id,$subscribers )) {
            if ($sportSession->available != 0) {
                $invoice = new Invoice();
                $invoice->project_id = $request->project_id ?? null;
                $invoice->client_id = $user->id;
                $invoice->invoice_number = Invoice::lastInvoiceNumber() + 1;
                $invoice->issue_date = Carbon::now();
                $invoice->due_date = Carbon::now();
                $invoice->sub_total = round($sportSession->fees, 2);
                $invoice->discount = 0;
                $invoice->discount_type = 'percent';
                $invoice->total = round($sportSession->fees, 2);
                $invoice->currency_id = Currency::where('currency_code',$sportSession->currency)->first()->id;
                $invoice->recurring = 'no';
                $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
                $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
                $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
                $invoice->note = 'paid for '.User::find($user_id)->name;
                $invoice->show_shipping_address = 'no';
                $invoice->created_by = $user->id;
                $invoice->save();
                InvoiceItems::create(
                    [
                        'invoice_id' => $invoice->id,
                        'item_name' => $sportSession->session_name.' #'.$sportSession->session_id,
                        'item_summary' => '',
                        'hsn_sac_code' =>  null,
                        'type' => 'item',
                        'quantity' => 1.00,
                        'unit_price' => round($sportSession->fees, 2),
                        'amount' => round($sportSession->fees, 2),
                        'taxes' =>null
                    ]
                );
                $notifyUser = $invoice->client;
                if (!is_null($notifyUser)) {
                    $notifyUser->notify(new NewInvoice($invoice));
                }

                $invoice->send_status = 1;
                $invoice->save();
                $subscribe = new SessionMember();
                    $subscribe->user_id = $user_id;
                    $subscribe->session_id = $sportSession->session_id;
                    $subscribe->status = 'subscription';
                    $subscribe->save();
                foreach ($relatedSessions as $relatedSession) {
                    $relatedSession->available--;
                    $relatedSession->save();

                }
                return Reply::success(__('messages.subscription_done'));
            } else {
                $subscribe = new SessionMember();
                $subscribe->user_id = $user_id;
                $subscribe->session_id = $sportSession->session_id;
                $subscribe->status = 'waiting';
                $subscribe->save();
                foreach ($relatedSessions as $relatedSession) {
                    $relatedSession->waiting++;
                    $relatedSession->save();
                }
                return Reply::success(__('messages.added_to_waiting_list'));
            }
        }
        else{
            return Reply::error(__('messages.user_subscribed_already'));

        }

    }
    public function sportEventFilter(Request $request){
        $sportSession=SportSession::select('*');

        if (request()->has('sport') && $request->sport != 0) {
            $sportSession->where('sport_id',  $request->sport);
        }
        if (request()->has('level') && $request->level != 0) {
            $sportSession->where('level_id',  $request->level);
        }
        if (request()->has('group') && $request->group != 0) {
            $sportSession->where('group_id',  $request->group);
        }
        if (request()->has('coach') && $request->coach != 0) {
            $sportSession->where('coach_id',  $request->coach);
        }
        if (request()->has('location_id') && $request->location_id != 0) {
            $sportSession->where('location_id',  $request->location_id);
        }
        $sportSession = $sportSession->get();

        $taskEvents = array();
        foreach ($sportSession as $key => $value) {
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
                    'title' => $value->session_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            }else{
                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->session_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time
                ];
            }

        }
        return $taskEvents;
    }
    public function mySportEventFilter(Request $request){
        $sportSession=SportSession::select('*');
        $subscribedSessions=SessionMember::where('user_id' , auth()->user()->id)->where('status' , 'subscription')->get();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribedIds[$i]=$session->session_id;
            $i++;
        }
        if (request()->has('sport') && $request->sport != 0) {
            $sportSession->where('sport_id',  $request->sport);
        }
        if (request()->has('level') && $request->level != 0) {
            $sportSession->where('level_id',  $request->level);
        }
        if (request()->has('group') && $request->group != 0) {
            $sportSession->where('group_id',  $request->group);
        }
        if (request()->has('coach') && $request->coach != 0) {
            $sportSession->where('coach_id',  $request->coach);
        }
        if (request()->has('location_id') && $request->location_id != 0) {
            $sportSession->where('location_id',  $request->location_id);
        }
        $sportSession = $sportSession->whereIn('session_id' , $subscribedIds)->get();

        $taskEvents = array();
        foreach ($sportSession as $key => $value) {
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
                    'title' => $value->session_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            }else{
                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->session_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time
                ];
            }

        }
        return $taskEvents;
    }
    public function familyMembers(FamilyMembersDataTable $dataTable){
        $id=auth()->user()->id;
        $this->memberUser = User::where('id' , $id)->first();
        $this->member = memberDetails::where('user_id' , $id)->first();
        $this->members = $this->member->family();
        $this->categories = memberCategory::where('id' , $this->member->category_id )->first();
        $this->relations = memberRelations::where('id' , $this->member->relation_id )->first();
        $this->status = memberStatus::where('id' , $this->member->status_id )->first();
        return $dataTable->render('club.family_members', $this->data);
    }

    public function familySessions(){
        $this->sports = SportAcademy::all();
        $this->currencies=Currency::all();
        $this->levels = Level::all();
        $this->groups = PlayerGroup::all();
        $this->locations = Location::all();
        $this->coaches=EmployeeDetails::where('designation_id' , 1)->get();

        return view('club.family_sessions', $this->data );
    }

    public function familySportEventFilter(Request $request){
        $sportSession=SportSession::select('*');
        $j=0;
//        $familyMember_ids=array();
//        $subscribedIds=array();
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familyMembers=memberDetails::where('family_id' ,$member->family_id )->where('user_id' , '!=' , auth()->user()->id)->get();
        foreach ($familyMembers as $familyMember){
            $familyMember_ids[$j]=$familyMember->user_id;
            $j++;
        }
        $subscribedSessions=SessionMember::whereIn('user_id' , $familyMember_ids)->where('status' , 'subscription')->get();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribedIds[$i]=$session->session_id;
            $i++;
        }
        if (request()->has('sport') && $request->sport != 0) {
            $sportSession->where('sport_id',  $request->sport);
        }
        if (request()->has('level') && $request->level != 0) {
            $sportSession->where('level_id',  $request->level);
        }
        if (request()->has('group') && $request->group != 0) {
            $sportSession->where('group_id',  $request->group);
        }
        if (request()->has('coach') && $request->coach != 0) {
            $sportSession->where('coach_id',  $request->coach);
        }
        if (request()->has('location_id') && $request->location_id != 0) {
            $sportSession->where('location_id',  $request->location_id);
        }
        $sportSession = $sportSession->whereIn('session_id' , $subscribedIds)->get();

        $taskEvents = array();
        foreach ($sportSession as $key => $value) {
            foreach ($familyMembers as $familyMember) {
                if (SessionMember::where('session_id', $value->session_id)->where('user_id', $familyMember->user_id)->first()) {

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
                            'title' => $familyMember->name." : ".$value->session_name,
                            'className' => $value->label_color,
                            'start' => $value->start_date_time,
                            'end' => $value->end_date_time,

                        ];
                    } else {
                        $taskEvents[] = [
                            'id' => $value->id,
                            'title' => $familyMember->name." : ".$value->session_name,
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
    public function familyAttendanceByPlayer()
    {
        $this->pageTitle = 'app.menu.attendance';
        $this->pageIcon = 'icon-calender';
        $member=memberDetails::where('user_id' , auth()->user()->id)->first();
        $openDays = json_decode($this->attendanceSettings->office_open_days);
        $this->startDate = Carbon::today()->timezone($this->global->timezone)->startOfMonth();
        $this->endDate = Carbon::now()->timezone($this->global->timezone);
        $this->employees = memberDetails::where('player' , 1)->where('family_id' , $member->family_id)->get();
        $this->userId = User::first()->id;

        $this->totalWorkingDays = $this->startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
            foreach ($openDays as $day) {
                if ($date->dayOfWeek == $day) {
                    return $date;
                }
            }
        }, $this->endDate);
        $this->daysPresent = Attendance::countDaysPresentByUser($this->startDate, $this->endDate, $this->userId);
        $this->daysLate = Attendance::countDaysLateByUser($this->startDate, $this->endDate, $this->userId);
        $this->halfDays = Attendance::countHalfDaysByUser($this->startDate, $this->endDate, $this->userId);
        $this->holidays = Count(Holiday::getHolidayByDates($this->startDate->format('Y-m-d'), $this->endDate->format('Y-m-d')));

        return view('club.attendance.att_by_player', $this->data);
    }
    public function refreshCount(Request $request, $startDate = null, $endDate = null, $userId = null)
    {

        $openDays = json_decode($this->attendanceSettings->office_open_days);
        // $startDate = Carbon::createFromFormat('!Y-m-d', $startDate);
        // $endDate = Carbon::createFromFormat('!Y-m-d', $endDate)->addDay(1); //addDay(1) is hack to include end date
        $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate);
        $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->addDay(1); //addDay(1) is hack to include end date
        $userId = $request->userId;

        $totalWorkingDays = $startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
            foreach ($openDays as $day) {
                if ($date->dayOfWeek == $day) {
                    return $date;
                }
            }
        }, $endDate);
        $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate);
        $daysPresent = Attendance::countDaysPresentByUser($startDate, $endDate, $userId);
        $daysLate = Attendance::countDaysLateByUser($startDate, $endDate, $userId);
        $halfDays = Attendance::countHalfDaysByUser($startDate, $endDate, $userId);
        $daysAbsent = (($totalWorkingDays - $daysPresent) < 0) ? '0' : ($totalWorkingDays - $daysPresent);
        $holidays = Count(Holiday::getHolidayByDates($startDate->format('Y-m-d'), $endDate->format('Y-m-d')));

        return Reply::dataOnly(['daysPresent' => $daysPresent, 'daysLate' => $daysLate, 'halfDays' => $halfDays, 'totalWorkingDays' => $totalWorkingDays, 'absentDays' => $daysAbsent, 'holidays' => $holidays]);
    }

    public function employeeData(Request $request, $startDate = null, $endDate = null, $userId = null)
    {
        $ant = []; // Array For attendance Data indexed by similar date
        $dateWiseData = []; // Array For Combine Data

        $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->startOfDay();
        $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->endOfDay()->addDay(1);

        $attendances = Attendance::userAttendanceByDate($startDate, $endDate, $userId); // Getting Attendance Data
        $holidays = Holiday::getHolidayByDates($startDate, $endDate); // Getting Holiday Data

        // Getting Leaves Data
        $leavesDates = Leave::where('user_id', $userId)
            ->where('leave_date', '>=', $startDate)
            ->where('leave_date', '<=', $endDate)
            ->where('status', 'approved')
            ->select('leave_date', 'reason')
            ->get()->keyBy('date')->toArray();

        $holidayData = $holidays->keyBy('holiday_date');
        $holidayArray = $holidayData->toArray();

        // Set Date as index for same date clock-ins
        foreach ($attendances as $attand) {
            $ant[$attand->clock_in_date][] = $attand; // Set attendance Data indexed by similar date
        }

        $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->timezone($this->global->timezone);
        $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->timezone($this->global->timezone)->subDay();

        // Set All Data in a single Array
        for ($date = $endDate; $date->diffInDays($startDate) > 0; $date->subDay()) {

            // Set default array for record
            $dateWiseData[$date->toDateString()] = [
                'holiday' => false,
                'attendance' => false,
                'leave' => false
            ];

            // Set Holiday Data
            if (array_key_exists($date->toDateString(), $holidayArray)) {
                $dateWiseData[$date->toDateString()]['holiday'] = $holidayData[$date->toDateString()];
            }

            // Set Attendance Data
            if (array_key_exists($date->toDateString(), $ant)) {
                $dateWiseData[$date->toDateString()]['attendance'] = $ant[$date->toDateString()];
            }

            // Set Leave Data
            if (array_key_exists($date->toDateString(), $leavesDates)) {
                $dateWiseData[$date->toDateString()]['leave'] = $leavesDates[$date->toDateString()];
            }
        }

        // Getting View data
        $view = view('admin.attendance.user_attendance', ['dateWiseData' => $dateWiseData, 'global' => $this->global])->render();

        return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }

}