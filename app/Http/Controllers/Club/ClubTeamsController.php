<?php

namespace App\Http\Controllers\Club;

use App\DataTables\Admin\SportsTeamsDataTable;
use App\DataTables\Club\ClubTeamsDataTable;
use App\sports;
use App\sportsTeams;

class ClubTeamsController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sportsTeams';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(ClubTeamsDataTable $dataTable){
        $this->teams=sportsTeams::all();
        $this->totalTeams=count($this->teams);
        $this->sports=sports::all();
        return $dataTable->render('club.sport-teams.index', $this->data);
    }
}