<?php

namespace App\Http\Controllers\Admin;

use App\Location;
use App\Helper\Reply;
use App\Http\Requests\Admin\RentArea\StoreRentAreaRequest;
use App\Project;
use App\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GlobalSetting;
use App\DataTables\Admin\locationsDataTable;
use App\DataTables\Admin\AreaRentDataTable;
use App\AreaRent;
use App\RentedArea;
use App\EmployeeDetails;
use Carbon\Carbon;

use App\Currency;
use App\ Level;
use App\ PlayerGroup;
use App\SportAcademy;
use App\SportSession;


class AreaRentController extends AdminBaseController
// AdminBaseController
{

    //rola
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-layers';
        $this->pageTitle = 'app.menu.AreaRent';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules), 403);
            return $next($request);
        });
        
        
    //  OR
    //     parent::__construct();
    //     //Fail-safe page titile
    //     $this->pageTitle='Area Rents';
    //     // $this->pageIcon = 'fa fa-file-text';
    //     $this->middleware(function ($request, $next) {
    //         //localize Page title based on current locale
    //         $this->pageTitle = __('accounting::modules.accounting.AreaRents');
    //         // if (!in_array('Area Rents', $this->modules)) {
    //         //     abort(403);
    //         // }    // to be added after adding the accounting module inside the db table of working modules
    //         return $next($request);
    //     });
        // or OR
//         parent::__construct();
//         $this->pageTitle = 'app.menu.rents';
//         $this->pageIcon = 'icon-rents';
//         $this->middleware(function ($request, $next) {
// //            abort_if((!in_array('sportAcademies', $this->user->modules))||(!in_array('sportTeams', $this->user->modules)),403);
//             return $next($request);
//         });
// or OR
// return view('public-gdpr.lead', [
//     'pageTitle' => $pageTitle,
//     'lead'  =>  $lead,
//     'sources'  =>  $sources,
//     'status'  =>  $status,
//     'gdprSetting'  =>  $gdprSetting

// ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AreaRentDataTable $dataTable){
        $this->AreaRents=AreaRent::all();
        $this->totalAreaRents = count($this->AreaRents);
        // return $dataTable->render('admin.area-rents.index',$this->data);
        return $dataTable->render('admin.area-rents.index', $this->data);
    }
    public function calender(){
        $this->trainings= RentedArea::all();
        $this->RentedArea=RentedArea::all();
        
        $this->AreaRents=AreaRent::all();

        $this->totalAreaRents = count($this->AreaRents);
        // $this->sports =sports::all();
        // $this->teams=sportsTeams::all();
        // $this->locations = Location::all();

        // return view('admin.sport-teams.teams_calender', $this->data );

        
        

        // $this->sports = SportAcademy::all();
        // $sessions = SportSession::all();
        // $i = 0;
        // $IDsArray = array();
        // foreach ($sessions as $session) {
        //     if (!in_array($session->session_id, $IDsArray)) {
        //         $IDsArray[$i] = $session->session_id;
        //     }
        //     $i++;
        // }
        // $this->session_ids = $IDsArray;
        // $this->currencies = Currency::all();
        // $this->levels = Level::all();
        // $this->groups = PlayerGroup::all();
        // $this->locations = Location::all();
        // $this->coaches = EmployeeDetails::where('designation_id', 1)->get();

        // return view('admin.sport-academy.sports_calender', $this->data);
        return view('admin.area-rents.index_calender', $this->data);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ public function create()
    {
        $this->AreaRents=AreaRent::all();
        // $AreaRents=AreaRent::all();

        return view('admin.area-rents.create_rented_area',$this->data); 
        // return view('admin.area-rents.create_rented_area',$this->data)->with(compact('AreaRents'));
        
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRentAreaRequest $request)
    // StoreRentAreaRequest
    {
        // Request $request,$id
        // abort_if(!$this->user->cans('adyyyd_legalAffairs'),403);

        $RentedArea=new RentedArea();
       
    $RentedArea->area_rent_details_id=$request->input('hall_name_id');
    // $RentedArea->status='generated';
    $RentedArea->price=$request->input('fees'); 
    $RentedArea->phone_number=$request->input('phonenumber_id'); 
    $RentedArea->client_name=$request->input('clientname_id'); 
 
    $RentedArea->start_date_time = Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->start_time)->format('H:i:s');
    $RentedArea->end_date_time = Carbon::createFromFormat($this->global->date_format, $request->end_date)->format('Y-m-d') . ' ' . Carbon::createFromFormat($this->global->time_format, $request->end_time)->format('H:i:s');
    if ($request->repeat) {
        $RentedArea->session_repeat = $request->repeat;
    } else {
        $RentedArea->session_repeat = 'no';
    }
    if ($request->guardian_employee) {
        $RentedArea->guardian = $request->guardian_employee;
        $RentedArea->employee_details_id=EmployeeDetails::all()->random()->id;
    } else {
        $RentedArea->guardian = 'no';
    }


   $RentedArea->repeat_every = $request->repeat_count;
   $RentedArea->repeat_cycles = $request->repeat_cycles;
   $RentedArea->repeat_type = $request->repeat_type;
   $RentedArea->label_color = $request->label_color;
    $RentedArea->save();

    if ($request->has('repeat') && $request->repeat == 'yes') {
        $repeatCount = $request->repeat_count;
        $repeatType = $request->repeat_type;
        $repeatCycles = $request->repeat_cycles;

        $startDate = Carbon::createFromFormat($this->global->date_format, $request->start_date);
        $dueDate = Carbon::createFromFormat($this->global->date_format, $request->end_date);

        for ($i = 1; $i < $repeatCycles; $i++) {
            $startDate = $startDate->add($repeatCount, str_plural($repeatType));
            $dueDate = $dueDate->add($repeatCount, str_plural($repeatType));

            $session = new RentedArea();
            $session->session_name = $request->input('session_name');
            $session->session_id = $request->input('session_id');
            $session->reservation_type = $request->input('reservation_type');
            $session->location_id = $request->input('location_id');
            $session->sport_id = $request->input('sport_id');
            $session->level_id = $request->input('level_id');
            $session->group_id = $request->input('group_id');
            $session->coach_id = $request->input('coach_id');
            $session->capacity = $request->input('capacity');
            $session->available = $request->input('capacity');
            $session->waiting = '0';
            $session->fees = $request->input('fees');
            $session->currency = $request->input('currency');
            $session->start_date_time = $startDate->format('Y-m-d') . ' ' . Carbon::parse($request->start_time)->format('H:i:s');
            $session->end_date_time = $dueDate->format('Y-m-d') . ' ' . Carbon::parse($request->end_time)->format('H:i:s');
            if ($request->repeat) {
                $session->repeat = $request->repeat;
            } else {
                $session->repeat = 'no';
            }

            $session->repeat_every = $request->repeat_count;
            $session->repeat_cycles = $request->repeat_cycles;
            $session->repeat_type = $request->repeat_type;
            $session->label_color = $request->label_color;
            $session->save();
        }
    }
    
    return Reply::success(__('messages.eventCreateSuccess'));
    }



    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        // $this->startDate = explode(' ', request('start'));
        // $this->startDate = Carbon::parse($this->startDate[0]);
        // $this->training=RentedArea::where('id',$id)->first();
        // $this->location= $this->training->rentAreaDetails->location;
        // $this->sport='qqqqqqqqqqqqqqqqqqqqqq';
        // $this->team='wwwwwwwwwwwwww';
        
        $this->startDate = explode(' ', request('start'));
        $this->startDate = Carbon::parse($this->startDate[0]);
        $this->training=RentedArea::where('id',$id)->first();
        

        return view('admin.area-rents.show_event', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    // public function inputValue(Request $request)
    // {
    //     $checkHoliday = AreaRent::find('id',$request->date);
    //     // return view('admin.area-rents.index',$this->data)->render();
    //     return Reply::dataOnly(['status' => 'success', 'holiday' => $checkHoliday]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function CalenderFilter(Request $request){
        $trainingsss=RentedArea::select('*');

        // if (request()->has('sport') && $request->sport != 0) {
        //     $training->where('sport_id',  $request->sport);
        // }
        // if (request()->has('training') && $request->training != 0) {
        //     $training->where('id',  $request->training);
        // }
       
        // if (request()->has('location_id') && $request->location_id != 0) {
        //     $training->where('location_id',  $request->location_id);
        // }
        $trainingtrainingsss = $trainingsss->get();

        $taskEvents = array();
        foreach ($trainingtrainingsss as  $value) {
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
                    'title' =>'wwwwww',
                    'className' => $value->label_color,
                    'location' => $value->location,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,
                    'textColor'=>'red',

                ];
            }else{
                $taskEvents[] = [
                    
                    'id' => $value->area_rent_details_id,
                    // 'title' => $value->location,
                    // 'title' =>  $value->rentAreaDetails(AreaRent::class,'area_rent_details_id'),
                    'title' =>  $value->rentAreaDetails->area_name . ' Capacity:'.$value->rentAreaDetails->area_capacity.'' . ' Capacity:'.$value->rentAreaDetails->location.'',

                    // 'title' =>  $value->rentAreaDetails->area_name . ' Capacity:'.$value->rentAreaDetails->area_capacity.'' . ' Capacity:'.$value->rentAreaDetails->location.'',
                    'location' =>  $value->rentAreaDetails->location,
 'hi'=>$value->rentAreaDetails->area_capacity, 

                    // 'title' => $value->area_rent_details_id,

                    // 'title' =>  '$training->rentAreaDetails->area_name',

                    // 'title' => $value->start_date_time, //working
                    // 'title' => '$value->rentAreaDetails->area_name',

                    // 'ClassNames' => [  'Capacity:'.$value->rentAreaDetails->area_capacity.'', ],
                    // 'location' => '$value->location',
    // 'backgroundColor'=>$value->label_color,
                    'start' => $value->start_date_time,
                    'end' => $value->end_date_time,
                    'color'=>'gray',
                    'borderColor'=>'red',
                    // 'extraParams'=>['sport' , ' sport',],
                   
                        
                    
                   
                ];
                // $taskEvents=json_encode($taskEvents);
            }

        }
        return $taskEvents;
    }
}
