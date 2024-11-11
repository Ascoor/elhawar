<?php

namespace App\Http\Controllers\Club;

use App\DataTables\Admin\SportsDataTable;
use App\DataTables\Club\ClubSportsDataTable;
use App\sports;

class ClubSportsController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sports';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }

    public function index(ClubSportsDataTable $dataTable){
        $this->sports=Sports::all();
        $this->totalSports = count($this->sports);
        return $dataTable->render('club.sports.index', $this->data);
    }
}