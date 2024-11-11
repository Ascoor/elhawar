<?php

namespace App\Http\Controllers\Admin;

use App\ClientSubCategory;
use App\Country;
use App\DataTables\Admin\AddPlayerDataTable;
use App\DataTables\Admin\TeamPlayersDataTable;
use App\DataTables\Admin\SportsTeamsDataTable;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Club\StoreTeamsRequest;
use App\memberCategory;
use App\memberDetails;
use App\sports;
use App\sportsTeams;
use App\TeamsCoaches;
use Illuminate\Http\Request;

class SportsTeamsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sportsTeams';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('sportTeams', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(SportsTeamsDataTable $dataTable){
        abort_if(!$this->user->cans('view_sportTeams'),403);

        $this->teams=sportsTeams::all();
        $this->totalTeams=count($this->teams);
        $this->sports=sports::all();
        return $dataTable->render('admin.sport-teams.index', $this->data);
    }
    public function create()
    {
        abort_if(!$this->user->cans('add_sportTeams'),403);

        // return 
        $this->sports = sports::all(); 
           $this->coaches=EmployeeDetails::where('designation_id' ,'=', 1)->get();

        return view('admin.sport-teams.create', $this->data );
    }
    public function store(StoreTeamsRequest $request){
        abort_if(!$this->user->cans('add_sportTeams'),403);

        $team=new sportsTeams();
        $team->team_name=$request->team_name;
        $team->from_age=$request->from_age;
        $team->to_age=$request->to_age;
        $team->sport_id=$request->sport_id;
        $team->save();
        foreach ($request->coach_id as $id){
            $teamCoach=new TeamsCoaches();
            $teamCoach->coach_id = $id;
            $teamCoach->team_id = $team->id;
            $teamCoach->save();
        }
        return Reply::redirect(route('admin.sportsTeams.index'));

    }
    public function edit($id){
        abort_if(!$this->user->cans('edit_sportTeams'),403);

        $this->team=sportsTeams::find($id);
        $this->teamscoaches=TeamsCoaches::where('team_id' , $id)->get();
        $i=0;
        $coachesArr=array();
        foreach ($this->teamscoaches as $teamscoach){
            $coachesArr[$i]=$teamscoach->coach_id;
            $i++;
        }
        $this->coachesArr=$coachesArr;
        $this->sports=sports::all();
        $this->coaches=EmployeeDetails::where('designation_id' , 1)->get();
        return view('admin.sport-teams.edit', $this->data );
    }
    public function update(StoreTeamsRequest $request , $id){
        abort_if(!$this->user->cans('edit_sportTeams'),403);

        $team=sportsTeams::find($id);
        $team->team_name=$request->team_name;
        $team->from_age=$request->from_age;
        $team->to_age=$request->to_age;
        $team->sport_id=$request->sport_id;
        $team->save();
        $teamsCoaches=TeamsCoaches::where('team_id' , $id)->get();
        foreach ($teamsCoaches as $teamsCoach){
            $teamsCoach->delete();
        }
        foreach ($request->coach_id as $coach_id){
            $teamCoach=new TeamsCoaches();
            $teamCoach->coach_id = $coach_id;
            $teamCoach->team_id = $team->id;
            $teamCoach->save();
        }
        return Reply::redirect(route('admin.sportsTeams.index'));
    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_sportTeams'),403);

        $team=sportsTeams::find($id);
        $players=memberDetails::where('team_id' , $id)->get();
        foreach ($players as $player){
            $this->removePlayer($player->id , $id);
        }
        $teamsCoaches=TeamsCoaches::where('team_id' , $id)->get();
        foreach ($teamsCoaches as $teamsCoach){
            $teamsCoach->delete();
        }
        $team->delete();
        return Reply::success(__('messages.teamDeleteSuccess'));
    }
    public function addPlayerIndex(AddPlayerDataTable $dataTable , $team_id){
        abort_if(!$this->user->cans('add_sportTeams'),403);

        $this->players = memberDetails::where('player' , 1)->where('team_id' , '<>' , $team_id)->get();
        $this->totalmembers = count($this->players);
        $this->categories = memberCategory::where('id' , '<>' , 1)->get();
        $this->countries = Country::all();
        $this->teams=sportsTeams::where('id' , '<>' , $team_id)->get();
        $this->this_team=$team_id;
        $dataTable->this_team=$team_id;
        return $dataTable->render('admin.sport-teams.add_player', $this->data);
    }
    public function addPlayer($id , $team_id){
        abort_if(!$this->user->cans('add_sportTeams'),403);

        $player=memberDetails::find($id);
        $player->team_id=$team_id;
        $player->save();
        return Redirect(route('admin.sportsTeams.addPlayerIndex' , $team_id));
    }
    public function teamPlayers(TeamPlayersDataTable $dataTable ,$team_id){
        abort_if(!$this->user->cans('view_sportTeams'),403);

        $this->players = memberDetails::where('player' , 1)->where('team_id' , $team_id)->get();
        $this->totalmembers = count($this->players);
        $this->categories = memberCategory::where('id' , '<>' , 1)->get();
        $this->countries = Country::all();
        $this->this_team=$team_id;
        $dataTable->this_team=$team_id;
        return $dataTable->render('admin.sport-teams.team_players', $this->data);
    }
    public function removePlayer($id ,  $team_id){

        abort_if(!$this->user->cans('delete_sportTeams'),403);

        $player=memberDetails::find($id);
        $player->team_id=0;
        $player->save();
        return Redirect(route('admin.sportsTeams.teamPlayers' , $team_id));
    }
}
