<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\EmployeeDetails;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Club\StoreTripRequest;
use App\Trips;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TripsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.trips_calender';
        $this->pageIcon = 'icon-calender';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('trips', $this->user->modules),403);
            return $next($request);
        });
    }
    public function show($id){
        abort_if(!$this->user->cans('view_trips'),403);

        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->trip=Trips::where('id',$id)->first();
        $this->supervisor=EmployeeDetails::where('user_id' ,$this->trip->supervisor_id )->first();





        return view('admin.trips.show', $this->data);
    }
    public function tripFilter(Request $request){
        abort_if(!$this->user->cans('view_trips'),403);

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
        $trip = $trip->get();

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
    public function create()
    {
        abort_if(!$this->user->cans('add_trips'),403);



        $this->currencies=Currency::all();
        $this->trips=Trips::all();
        $this->supervisors=EmployeeDetails::all();

        return view('admin.trips.trip_calender', $this->data );
    }
    public function store(StoreTripRequest $request){
        abort_if(!$this->user->cans('add_trips'),403);


        $trip=new Trips();
        $trip->trip_name=$request->input('trip_name');
        $trip->program=$request->input('program');
        $trip->supervisor_id=$request->input('supervisor_id');
        $trip->capacity=$request->input('capacity');
        $trip->available=$request->input('capacity');
        $trip->member_fees=$request->input('member_fees');
        $trip->non_member_fees=$request->input('non_member_fees');
        $trip->escort_fees=$request->input('escort_fees');
        $trip->currency=$request->input('currency');
        if ($request->hasFile('image')) {
            $trip->image = Files::upload($request->image, 'avatar', 300);
        }
        $trip->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $trip->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $trip->repeat = $request->repeat;
        } else {
            $trip->repeat = 'no';
        }

        $trip->repeat_every = $request->repeat_count;
        $trip->repeat_cycles = $request->repeat_cycles;
        $trip->repeat_type = $request->repeat_type;
        $trip->label_color = $request->label_color;
        $trip->save();
        if ($request->has('repeat') && $request->repeat == 'yes') {
            $repeatCount = $request->repeat_count;
            $repeatType = $request->repeat_type;
            $repeatCycles = $request->repeat_cycles;

            $startDate = Carbon::createFromFormat($this->global->date_format, $request->start_date);
            $dueDate = Carbon::createFromFormat($this->global->date_format, $request->end_date);

            for ($i = 1; $i < $repeatCycles; $i++) {
                $startDate = $startDate->add($repeatCount, str_plural($repeatType));
                $dueDate = $dueDate->add($repeatCount, str_plural($repeatType));

                $trip=new Trips();
                $trip->trip_name=$request->input('trip_name');
                $trip->program=$request->input('program');
                $trip->supervisor_id=$request->input('supervisor_id');
                $trip->capacity=$request->input('capacity');
                $trip->available=$request->input('capacity');
                $trip->member_fees=$request->input('member_fees');
                $trip->non_member_fees=$request->input('non_member_fees');
                $trip->escort_fees=$request->input('escort_fees');
                $trip->currency=$request->input('currency');
                if ($request->hasFile('image')) {
                    $trip->image = Files::upload($request->image, 'avatar', 300);
                }
                $trip->start_date_time = $startDate->format('Y-m-d') . ' ' . Carbon::parse($request->start_time)->format('H:i:s');
                $trip->end_date_time = $dueDate->format('Y-m-d') . ' ' . Carbon::parse($request->end_time)->format('H:i:s');
                if ($request->repeat) {
                    $trip->repeat = $request->repeat;
                } else {
                    $trip->repeat = 'no';
                }

                $trip->repeat_every = $request->repeat_count;
                $trip->repeat_cycles = $request->repeat_cycles;
                $trip->repeat_type = $request->repeat_type;
                $trip->label_color = $request->label_color;
                $trip->save();
            }
        }
        return Reply::success(__('messages.eventCreateSuccess'));

    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_trips'),403);

        Trips::destroy($id);
        return Reply::success(__('messages.eventDeleteSuccess'));
    }

    public function edit($id){
        abort_if(!$this->user->cans('edit_trips'),403);

        $this->currencies=Currency::all();
        $this->trip=Trips::find($id);
        $this->supervisors=EmployeeDetails::all();
        $view = view('admin.trips.edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);

    }
    public function update(StoreTripRequest $request , $id){
        abort_if(!$this->user->cans('edit_trips'),403);

        $trip=Trips::find($id);
        $trip->trip_name=$request->input('trip_name');
        $trip->program=$request->input('program');
        $trip->supervisor_id=$request->input('supervisor_id');
        $trip->capacity=$request->input('capacity');
        $trip->available=$request->input('capacity');
        $trip->member_fees=$request->input('member_fees');
        $trip->non_member_fees=$request->input('non_member_fees');
        $trip->escort_fees=$request->input('escort_fees');
        $trip->currency=$request->input('currency');
        if ($request->hasFile('image')) {
            $trip->image = Files::upload($request->image, 'avatar', 300);
        }
        $trip->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $trip->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $trip->repeat = $request->repeat;
        } else {
            $trip->repeat = 'no';
        }

        $trip->repeat_every = $request->repeat_count;
        $trip->repeat_cycles = $request->repeat_cycles;
        $trip->repeat_type = $request->repeat_type;
        $trip->label_color = $request->label_color;
        $trip->save();
        return Reply::success(__('messages.eventCreateSuccess'));

    }
}
