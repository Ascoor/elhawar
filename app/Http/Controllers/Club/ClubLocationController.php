<?php

namespace App\Http\Controllers\Club;

use App\DataTables\Admin\locationsDataTable;
use App\DataTables\Club\ClubLocationsDataTable;
use App\Location;

class ClubLocationController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.locations';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(ClubLocationsDataTable $dataTable){
        $this->locations=Location::all();
        $this->totalLocations = count($this->locations);
        return $dataTable->render('club.location.index', $this->data);
    }
}