<?php

namespace App\Http\Controllers\Admin;

use App\Championships;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Club\StoreChampRequest;
use App\Location;
use App\sports;
use App\sportsTeams;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChampionshipsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.championships_calender';
        $this->pageIcon = 'icon-calender';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('championships', $this->user->modules),403);
            return $next($request);
        });
    }
    public function create()
    {
        abort_if(!$this->user->cans('view_championships'),403);

        $this->sports =sports::all();
        $this->championships=Championships::all();
       $this->teams=sportsTeams::all();
        $this->locations = Location::all();

        return view('admin.championships.championships_calender', $this->data );
    }
    public function championshipsFilter(Request $request){
        abort_if(!$this->user->cans('view_championships'),403);

        $championship=Championships::select('*');

        if (request()->has('sport') && $request->sport != 0) {
            $championship->where('sport_id',  $request->sport);
        }
        if (request()->has('champ') && $request->champ != 0) {
            $championship->where('id',  $request->champ);
        }
        if (request()->has('champ_type') && $request->champ_type != 'all') {
            $championship->where('championship_type',  $request->champ_type);
        }
        if (request()->has('sport_type') && $request->sport_type != 'all') {
            $championship->where('sport_type',  $request->sport_type);
        }
        if (request()->has('location_id') && $request->location_id != 0) {
            $championship->where('location_id',  $request->location_id);
        }
        $championship = $championship->get();

        $taskEvents = array();
        foreach ($championship as $key => $value) {
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
                    'title' => $value->championship_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,

                ];
            }else{
                $taskEvents[] = [
                    'id' => $value->id,
                    'title' => $value->championship_name,
                    'className' => $value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time
                ];
            }

        }
        return $taskEvents;
    }
    public function store(StoreChampRequest $request){
        abort_if(!$this->user->cans('add_championships'),403);

        $championship=new Championships();
        $championship->championship_name=$request->championship_name;
        $championship->sport_type=$request->sport_type;
        $championship->championship_type=$request->championship_type;
        $championship->sport_id=$request->sport_id;
        $championship->location_id=$request->location_id;
        $championship->team_id=$request->team_id;
        $championship->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $championship->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $championship->repeat = $request->repeat;
        } else {
            $championship->repeat = 'no';
        }

        $championship->repeat_every = $request->repeat_count;
        $championship->repeat_cycles = $request->repeat_cycles;
        $championship->repeat_type = $request->repeat_type;
        $championship->label_color = $request->label_color;
        $championship->save();
        if ($request->has('repeat') && $request->repeat == 'yes') {
            $repeatCount = $request->repeat_count;
            $repeatType = $request->repeat_type;
            $repeatCycles = $request->repeat_cycles;

            $startDate = Carbon::createFromFormat($this->global->date_format, $request->start_date);
            $dueDate = Carbon::createFromFormat($this->global->date_format, $request->end_date);

            for ($i = 1; $i < $repeatCycles; $i++) {
                $startDate = $startDate->add($repeatCount, str_plural($repeatType));
                $dueDate = $dueDate->add($repeatCount, str_plural($repeatType));
                $championship=new Championships();
                $championship->championship_name=$request->championship_name;
                $championship->sport_type=$request->sport_type;
                $championship->championship_type=$request->championship_type;
                $championship->sport_id=$request->sport_id;
                $championship->location_id=$request->location_id;
                $championship->team_id=$request->team_id;
                $championship->start_date_time = $startDate->format('Y-m-d') . ' ' . Carbon::parse($request->start_time)->format('H:i:s');
                $championship->end_date_time = $dueDate->format('Y-m-d') . ' ' . Carbon::parse($request->end_time)->format('H:i:s');
                if ($request->repeat) {
                    $championship->repeat = $request->repeat;
                } else {
                    $championship->repeat = 'no';
                }

                $championship->repeat_every = $request->repeat_count;
                $championship->repeat_cycles = $request->repeat_cycles;
                $championship->repeat_type = $request->repeat_type;
                $championship->label_color = $request->label_color;
                $championship->save();
            }
        }
        return Reply::success(__('messages.eventCreateSuccess'));
    }
    public function show($id){
        abort_if(!$this->user->cans('view_championships'),403);

        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->championship=Championships::where('id',$id)->first();
        $this->location=Location::where('id',$this->championship->location_id)->first();
        $this->sport=sports::where('id',$this->championship->sport_id)->first();
        $this->team=sportsTeams::where('id' ,$this->championship->team_id)->first();


        return view('admin.championships.show', $this->data);
    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_championships'),403);

        Championships::destroy($id);
        return Reply::success(__('messages.eventDeleteSuccess'));
    }
    public function edit($id)
    {
        abort_if(!$this->user->cans('edit_championships'),403);

        $this->sports =sports::all();
        $this->championship=Championships::find($id);
        $this->teams=sportsTeams::all();
        $this->locations = Location::all();
        $view = view('admin.championships.edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }
    public function update(StoreChampRequest $request , $id)
    {
        abort_if(!$this->user->cans('edit_championships'),403);

        $championship=Championships::find($id);
        $championship->championship_name=$request->championship_name;
        $championship->sport_type=$request->sport_type;
        $championship->championship_type=$request->championship_type;
        $championship->sport_id=$request->sport_id;
        $championship->location_id=$request->location_id;
        $championship->team_id=$request->team_id;
        $championship->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
        $championship->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
        if ($request->repeat) {
            $championship->repeat = $request->repeat;
        } else {
            $championship->repeat = 'no';
        }

        $championship->repeat_every = $request->repeat_count;
        $championship->repeat_cycles = $request->repeat_cycles;
        $championship->repeat_type = $request->repeat_type;
        $championship->label_color = $request->label_color;
        $championship->save();
        return Reply::success(__('messages.eventCreateSuccess'));

    }
    }
