<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Currency;
use App\DataTables\Admin\locationsDataTable;
use App\DataTables\Admin\SportSessionDataTable;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Http\Requests\Admin\Club\StoreSportActivityRequest;
use App\Level;
use App\Location;
use App\memberCategory;
use App\memberDetails;
use App\memberRelations;
use App\memberStatus;
use App\PlayerGroup;
use App\RentedArea;
use App\SportAcademy;
use App\SportSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class SportActivityController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sessions_calender';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('clients', $this->user->modules), 403);
            return $next($request);
        });
    }
    //    public function index(locationsDataTable $dataTable){
//        $this->locations=Location::all();
//        $this->totalLocations = count($this->locations);
//        return $dataTable->render('admin.sport-session.index', $this->data);
//    }
    public function show($id)
    {
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->session = SportSession::where('id', $id)->first();
        $this->coach = EmployeeDetails::where('user_id', $this->session->coach_id)->first();
        $this->location = Location::where('id', $this->session->location_id)->first();
        $this->sport = SportAcademy::where('id', $this->session->sport_id)->first();
        $this->level = Level::where('id', $this->session->level_id)->first();
        $this->group = PlayerGroup::where('id', $this->session->group_id)->first();




        return view('admin.sport-academy.show', $this->data);
    }
    public function sportEventFilter(Request $request)
    {
        $sportSession = SportSession::select('*');

        if (request()->has('sport') && $request->sport != 0) {
            $sportSession->where('sport_id', $request->sport);
        }
        if (request()->has('level') && $request->level != 0) {
            $sportSession->where('level_id', $request->level);
        }
        if (request()->has('group') && $request->group != 0) {
            $sportSession->where('group_id', $request->group);
        }
        if (request()->has('coach') && $request->coach != 0) {
            $sportSession->where('coach_id', $request->coach);
        }
        if (request()->has('location_id') && $request->location_id != 0) {
            $sportSession->where('location_id', $request->location_id);
        }
        $sportSession = $sportSession->get();

        $taskEvents = array();
        foreach ($sportSession as $key => $value) {
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
                    'title' => $value->session_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            } else {
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
    public function create()
    {
        $this->sports = SportAcademy::all();
        // $sessions = SportSession::all();
        $sessions = RentedArea::all();

        $i = 0;
        $IDsArray = array();
        foreach ($sessions as $session) {
            if (!in_array($session->session_id, $IDsArray)) {
                $IDsArray[$i] = $session->session_id;
            }
            $i++;
        }
        $this->session_ids = $IDsArray;
        $this->currencies = Currency::all();
        $this->levels = Level::all();
        $this->groups = PlayerGroup::all();
        $this->locations = Location::all();
        $this->coaches = EmployeeDetails::where('designation_id', 1)->get();

        return view('admin.sport-academy.sports_calender', $this->data);
    }
    public function store(StoreSportActivityRequest $request)
    {
        //        $sportSessions=SportSession::all();
//
//        foreach ($sportSessions as $sportSession){
//            $reservedDays=json_decode($sportSession->training_days);
//            $reservedSarts=json_decode($sportSession->start_time);
//            $reservedEnds=json_decode($sportSession->end_time);
//            $reservedCount = count($reservedDays);
//            $inputCount = count($request->input('training_days'));
////            $intersect_days=array_intersect($request->input('training_days') , $reservedDays);
//
//                for ($i=0 ; $i<$count ; $i++) {
//                    if (in_array($reservedDays[$i],$request->input('training_days')) && $request->input('location_id') == $sportSession->location_id ){
//                    if ((Carbon::parse($reservedSarts[$i])->format('H:i A') <= Carbon::parse($request->input('start_time')[$i])->format('H:i A')
//                            && Carbon::parse($reservedEnds[$i])->format('H:i A') >= Carbon::parse($request->input('start_time')[$i])->format('H:i A'))
//                        || (Carbon::parse($reservedSarts[$i])->format('H:i A') <= Carbon::parse($request->input('end_time')[$i])->format('H:i A')
//                            && Carbon::parse($reservedEnds[$i])->format('H:i A') >= Carbon::parse($request->input('end_time')[$i])->format('H:i A'))
//                        || (Carbon::parse($reservedSarts[$i])->format('H:i A') >= Carbon::parse($request->input('start_time')[$i])->format('H:i A')
//                            && Carbon::parse($reservedEnds[$i])->format('H:i A') <= Carbon::parse($request->input('end_time')[$i])->format('H:i A'))
//                    ) {
//                        return Reply::error('Provided location already reserved at these times. Try with different times.');
//                    }
//                }
//        }
//        }
//        $training_days=$request->input('training_days');
//    $session->training_days=json_encode($training_days);

        //    for ($i=0 ; $i<$count ; $i++){
//        $session->training_days=$session->training_days.','.$training_days[$i];
//
//    }

        //    $i=0;
//    $j=0;
//    foreach ($request->input('start_time') as $time)
//    {
//        $start_time_arr[$i]=Carbon::parse($time)->format('H:i');
//        $i++;
//    }
//    foreach ($request->input('end_time') as $time)
//    {
//        $end_time_arr[$j]=Carbon::parse($time)->format('H:i');
//        $j++;
//    }
//    $session->start_time=json_encode($start_time_arr);
//    $session->end_time=json_encode($end_time_arr);


        //    return Reply::redirect(route('admin.sportAcademy.index'));

        $session = new SportSession();
        $session->session_name = $request->input('session_name');
        $session->session_id = $request->input('session_id');
        $session->reservation_type = $request->input('reservation_type');
        $session->location_id = $request->input('location_id');
        $session->sport_id = $request->input('sport_id');
        $session->level_id = $request->input('level_id');
        $session->group_id = $request->input('group_id');
        $session->coach_id = $request->input('coach_id');
        $session->capacity = $request->input('capacity');
        $session->available = $request->input('capacity');
        $session->waiting = '0';
        $session->fees = $request->input('fees');
        $session->currency = $request->input('currency');
        $session->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $session->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $session->repeat = $request->repeat;
        } else {
            $session->repeat = 'no';
        }

        $session->repeat_every = $request->repeat_count;
        $session->repeat_cycles = $request->repeat_cycles;
        $session->repeat_type = $request->repeat_type;
        $session->label_color = $request->label_color;
        $session->save();
        if ($request->has('repeat') && $request->repeat == 'yes') {
            $repeatCount = $request->repeat_count;
            $repeatType = $request->repeat_type;
            $repeatCycles = $request->repeat_cycles;

            $startDate = Carbon::createFromFormat($this->global->date_format, $request->start_date);
            $dueDate = Carbon::createFromFormat($this->global->date_format, $request->end_date);

            for ($i = 1; $i < $repeatCycles; $i++) {
                $startDate = $startDate->add($repeatCount, str_plural($repeatType));
                $dueDate = $dueDate->add($repeatCount, str_plural($repeatType));

                $session = new SportSession();
                $session->session_name = $request->input('session_name');
                $session->session_id = $request->input('session_id');
                $session->reservation_type = $request->input('reservation_type');
                $session->location_id = $request->input('location_id');
                $session->sport_id = $request->input('sport_id');
                $session->level_id = $request->input('level_id');
                $session->group_id = $request->input('group_id');
                $session->coach_id = $request->input('coach_id');
                $session->capacity = $request->input('capacity');
                $session->available = $request->input('capacity');
                $session->waiting = '0';
                $session->fees = $request->input('fees');
                $session->currency = $request->input('currency');
                $session->start_date_time = $startDate->format('Y-m-d') . ' ' . Carbon::parse($request->start_time)->format('H:i:s');
                $session->end_date_time = $dueDate->format('Y-m-d') . ' ' . Carbon::parse($request->end_time)->format('H:i:s');
                if ($request->repeat) {
                    $session->repeat = $request->repeat;
                } else {
                    $session->repeat = 'no';
                }

                $session->repeat_every = $request->repeat_count;
                $session->repeat_cycles = $request->repeat_cycles;
                $session->repeat_type = $request->repeat_type;
                $session->label_color = $request->label_color;
                $session->save();
            }
        }
        return Reply::success(__('messages.eventCreateSuccess'));
    }
    public function destroy($id)
    {
        SportSession::destroy($id);
        return Reply::success(__('messages.eventDeleteSuccess'));
    }

    public function edit($id)
    {
        //        $this->session=SportSession::find($id);
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->session = SportSession::where('id', $id)->first();
        $sessions = SportSession::all();
        $i = 0;
        $IDsArray = array();
        foreach ($sessions as $session) {
            if (!in_array($session->session_id, $IDsArray)) {
                $IDsArray[$i] = $session->session_id;
            }
            $i++;
        }
        $this->session_ids = $IDsArray;
        $this->sports = SportAcademy::all();
        $this->currencies = Currency::all();
        $this->levels = Level::all();
        $this->groups = PlayerGroup::all();
        $this->locations = Location::all();
        $this->coaches = EmployeeDetails::where('designation_id', 1)->get();
        $view = view('admin.sport-session.edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);

    }
    public function update(StoreSportActivityRequest $request, $id)
    {

        $session = SportSession::find($id);
        $session->session_name = $request->input('session_name');
        $session->session_id = $request->input('session_id');
        $session->reservation_type = $request->input('reservation_type');
        $session->location_id = $request->input('location_id');
        $session->sport_id = $request->input('sport_id');
        $session->level_id = $request->input('level_id');
        $session->group_id = $request->input('group_id');
        $session->coach_id = $request->input('coach_id');
        $session->capacity = $request->input('capacity');
        $session->available = $request->input('capacity');
        $session->waiting = '0';
        $session->fees = $request->input('fees');
        $session->currency = $request->input('currency');
        $session->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $session->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $session->repeat = $request->repeat;
        } else {
            $session->repeat = 'no';
        }

        $session->repeat_every = $request->repeat_count;
        $session->repeat_cycles = $request->repeat_cycles;
        $session->repeat_type = $request->repeat_type;
        $session->label_color = $request->label_color;
        $session->save();
        return Reply::success(__('messages.eventCreateSuccess'));

    }

}