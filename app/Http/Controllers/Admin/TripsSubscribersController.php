<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SubscribersDataTable;
use App\DataTables\Admin\TripsSubscribersDataTable;
use App\Helper\Reply;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use App\TripMember;
use App\Trips;

class TripsSubscribersController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.trips';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('trips', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(TripsSubscribersDataTable $dataTable){
        abort_if(!$this->user->cans('view_trips'),403);

        $this->trips=Trips::all();
//        $this->totalSports = count($this->sports);
        return $dataTable->render('admin.trips.subscribers_index', $this->data);
    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_trips'),403);

        $tripMember=TripMember::find($id);
        $trip=Trips::find($tripMember->trip_id);
        $trip->available++;
        $trip->save();
        $tripMember->delete();
        return Reply::success(__('messages.subscriptionDeleted'));
    }


}