<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\locationsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Club\StoreLocationsRequest;
use App\Location;
use Froiden\Envato\Helpers\Reply;
use Illuminate\Http\Request;

class LocationController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.locations';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
//            abort_if((!in_array('sportAcademies', $this->user->modules))||(!in_array('sportTeams', $this->user->modules)),403);
            return $next($request);
        });
    }
    public function index(locationsDataTable $dataTable){
        $this->locations=Location::all();
        $this->totalLocations = count($this->locations);
        return $dataTable->render('admin.location.index', $this->data);
    }
    public function create()
    {
        abort_if((!$this->user->cans('add_sportAcademies'))||(!$this->user->cans('add_sportTeams')),403);
        $this->locations = Location::all();
        return view('admin.sport-academy.create_location', $this->data);
    }
    public function store(StoreLocationsRequest $request)
    {
        abort_if((!$this->user->cans('add_sportAcademies'))||(!$this->user->cans('add_sportTeams')),403);

        $location = new Location();
        $location->name = $request->name;
        $location->capacity = $request->capacity;
        $location->description = $request->description;
        $location->guardian = $request->guardian;
        $location->save();
        $locationsData = Location::all();
        return Reply::successWithData(__('messages.locationAdded'),['data' => $locationsData]);
    }
    public function destroy($id)
    {
        abort_if((!$this->user->cans('delete_sportTeams'))||(!$this->user->cans('delete_sportAcademies')),403);

        Location::destroy($id);
        $locations = Location::all();
        return Reply::successWithData(__('messages.locationDeleted'),['data' => $locations]);
    }
}
