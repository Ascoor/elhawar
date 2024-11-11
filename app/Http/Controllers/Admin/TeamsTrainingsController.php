<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Requests\Admin\Club\StoreTeamEventRequest;
use App\Location;
use App\sports;
use App\sportsTeams;
use App\TeamsTrainings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function __;
use function abort_if;
use function request;
use function str_plural;
use function view;

class TeamsTrainingsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.teams_calender';
        $this->pageIcon = 'icon-calender';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }
    public function create()
    {
        $this->trainings= TeamsTrainings::all();
        $this->sports =sports::all();
        $this->teams=sportsTeams::all();
        $this->locations = Location::all();

        return view('admin.sport-teams.teams_calender', $this->data );
    }
    public function trainingsFilter(Request $request){
        $training=TeamsTrainings::select('*');

        if (request()->has('sport') && $request->sport != 0) {
            $training->where('sport_id',  $request->sport);
        }
        if (request()->has('training') && $request->training != 0) {
            $training->where('id',  $request->training);
        }
       
        if (request()->has('location_id') && $request->location_id != 0) {
            $training->where('location_id',  $request->location_id);
        }
        $training = $training->get();

        $taskEvents = array();
        foreach ($training as $key => $value) {
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

                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->event_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            }else{
                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->event_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time
                ];
            }

        }
        return $taskEvents;
    }
    public function store(StoreTeamEventRequest $request){
        $training=new TeamsTrainings();
        $training->event_name=$request->event_name;
        $training->sport_id=$request->sport_id;
        $training->location_id=$request->location_id;
        $training->team_id=$request->team_id;
        $training->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $training->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $training->repeat = $request->repeat;
        } else {
            $training->repeat = 'no';
        }

        $training->repeat_every = $request->repeat_count;
        $training->repeat_cycles = $request->repeat_cycles;
        $training->repeat_type = $request->repeat_type;
        $training->label_color = $request->label_color;
        $training->save();
        if ($request->has('repeat') && $request->repeat == 'yes') {
            $repeatCount = $request->repeat_count;
            $repeatType = $request->repeat_type;
            $repeatCycles = $request->repeat_cycles;

            $startDate = Carbon::createFromFormat($this->global->date_format, $request->start_date);
            $dueDate = Carbon::createFromFormat($this->global->date_format, $request->end_date);

            for ($i = 1; $i < $repeatCycles; $i++) {
                $startDate = $startDate->add($repeatCount, str_plural($repeatType));
                $dueDate = $dueDate->add($repeatCount, str_plural($repeatType));
                $training=new TeamsTrainings();
                $training->event_name=$request->event_name;
                $training->sport_id=$request->sport_id;
                $training->location_id=$request->location_id;
                $training->team_id=$request->team_id;
                $training->start_date_time = $startDate->format('Y-m-d') . ' ' . Carbon::parse($request->start_time)->format('H:i:s');
                $training->end_date_time = $dueDate->format('Y-m-d') . ' ' . Carbon::parse($request->end_time)->format('H:i:s');
                if ($request->repeat) {
                    $training->repeat = $request->repeat;
                } else {
                    $training->repeat = 'no';
                }

                $training->repeat_every = $request->repeat_count;
                $training->repeat_cycles = $request->repeat_cycles;
                $training->repeat_type = $request->repeat_type;
                $training->label_color = $request->label_color;
                $training->save();
            }
        }
        return Reply::success(__('messages.eventCreateSuccess'));
    }
    public function show($id){
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->training=TeamsTrainings::where('id',$id)->first();
        $this->location=Location::where('id',$this->training->location_id)->first();
        $this->sport=sports::where('id',$this->training->sport_id)->first();
        $this->team=sportsTeams::where('id' ,$this->training->team_id)->first();


        return view('admin.sport-teams.show_event', $this->data);
    }
    public function destroy($id){
        TeamsTrainings::destroy($id);
        return Reply::success(__('messages.eventDeleteSuccess'));
    }
    public function edit($id)
    {
        $this->sports =sports::all();
        $this->training=TeamsTrainings::find($id);
        $this->teams=sportsTeams::all();
        $this->locations = Location::all();
        $view = view('admin.sport-teams.edit_event', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }
    public function update(StoreTeamEventRequest $request , $id)
    {
        $training=TeamsTrainings::find($id);
        $training->event_name=$request->event_name;
        $training->sport_id=$request->sport_id;
        $training->location_id=$request->location_id;
        $training->team_id=$request->team_id;
        $training->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $training->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $training->repeat = $request->repeat;
        } else {
            $training->repeat = 'no';
        }

        $training->repeat_every = $request->repeat_count;
        $training->repeat_cycles = $request->repeat_cycles;
        $training->repeat_type = $request->repeat_type;
        $training->label_color = $request->label_color;
        $training->save();
        return Reply::success(__('messages.eventCreateSuccess'));

    }
}
