<?php

namespace App\Http\Controllers\Club;

use App\Location;
use App\memberDetails;
use App\sports;
use App\sportsTeams;
use App\TeamsTrainings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClubTeamsCalenderController extends ClubBaseController
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
    public function index(){
        $this->trainings= TeamsTrainings::all();
        $this->sports =sports::all();
        $this->teams=sportsTeams::all();
        $this->locations = Location::all();

        return view('club.sport-teams.teams_calender', $this->data );
    }
    public function trainingsFilter(Request $request){
        $member=memberDetails::where('user_id' , auth()->user()->id)->first();
        $familymembers=$member->family();
        $i=0;
        foreach ($familymembers as $familymember) {
            if ($familymember->player == 1) {
                $teamIds[$i] = $familymember->team_id;
                $i++;
            }
        }
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
        $training = $training->whereIn('team_id' , $teamIds)->get();

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

    public function show($id){
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->training=TeamsTrainings::where('id',$id)->first();
        $this->location=Location::where('id',$this->training->location_id)->first();
        $this->sport=sports::where('id',$this->training->sport_id)->first();
        $this->team=sportsTeams::where('id' ,$this->training->team_id)->first();


        return view('club.sport-teams.show_event', $this->data);
    }
}