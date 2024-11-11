<?php

namespace App\Http\Controllers\Club;

use App\Championships;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Location;
use App\memberDetails;
use App\sports;
use App\sportsTeams;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClubChampionshipsController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.championships_calender';
        $this->pageIcon = 'icon-calender';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(){
        $this->sports =sports::all();
        $this->championships=Championships::all();
        $this->teams=sportsTeams::all();
        $this->locations = Location::all();

        return view('club.championship.championships_calender', $this->data );
    }
    public function championshipsFilter(Request $request){
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familymembers=$member->family();
        $i=0;
        foreach ($familymembers as $familymember) {
            if ($familymember->player == 1) {
                $teamIds[$i] = $familymember->team_id;
                $i++;
        }
        }
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
        $championship = $championship->whereIn('team_id' , $teamIds)->get();

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
    public function show($id){
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->championship=Championships::where('id',$id)->first();
        $this->location=Location::where('id',$this->championship->location_id)->first();
        $this->sport=sports::where('id',$this->championship->sport_id)->first();
        $this->team=sportsTeams::where('id' ,$this->championship->team_id)->first();


        return view('club.championship.show', $this->data);
    }

}