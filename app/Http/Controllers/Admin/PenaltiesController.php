<?php

namespace App\Http\Controllers\Admin;

use App\Currency;



use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Penalty\StoreCaseRequest;
use App\Http\Requests\Admin\Penalty\StorePenaltyRequest;
use App\memberDetails;
use App\Penalties;
use App\User;
use App\AreaRent;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
//rola
// use app\Penlatyduraton; 
use App\PenaltiesDurations;

class PenaltiesController extends  AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.penalties';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('legalAffairs', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(){
        abort_if(!$this->user->cans('view_legalAffairs'),403);

        $this->employees=User::allEmployees();
        $this->clients=User::allClients();
        $this->Penalties=Penalties::all();
        $this->totalPenalties = count($this->Penalties);
        return view('admin.penalties.index', $this->data);
    }
    public function data(Request $request, $userId = null)
    {
        abort_if(!$this->user->cans('view_legalAffairs'),403);

        $penaltiesList = Penalties::select('penalties.id', 'users.name', 'penalties.penalty_name', 'penalties.status', 'penalties.details' , 'penalties.amount' , 'penalties.currency')
            ->join('users', 'users.id', '=', 'penalties.user_id');

        if ($userId != 0) {
            $penaltiesList->where('penalties.user_id', $userId);
        }
        if ($request->penalty_type != null) {
            $penaltiesList->where('penalties.penalty_name', $request->penalty_type );
        }
        if ($request->client_id != null) {
            $penaltiesList->where('penalties.user_id', $request->client_id );
        }
        if ($request->member_id != null) {
            $member=memberDetails::where('member_id' , $request->member_id)->first();
            $penaltiesList->where('penalties.user_id', $member->user_id );
        }


        $penalties = $penaltiesList->get();

        return DataTables::of($penalties)
            ->addColumn('user', function ($row) {
                return ucwords($row->name);
            })
            ->addColumn('penalty_type', function ($row) {
                $type = $row->penalty_name;

                return $type;
            })
            ->addColumn('amount', function ($row) {
                // // || $row->penalty_name=='Deduction' || $row->penalty_name=='Others'
                //rola 
                //if the pemalty_name is selected on  Financial Penalty or deductions or others 
                //then $amount can't be null
                if ($row->penalty_name=='Financial Penalty' || $row->penalty_name=='Deduction' || $row->penalty_name=='Others'){
                    $amount=$row->amount.$row->currency;
                }else{
                    $amount='--';
                }
                return $amount;
               
            })
            ->addColumn('status', function ($row) {
                if ($row->status == 'pending'){
                    $label= 'warning';
                }elseif ($row->status == 'approved'){
                    $label= 'success';
                }
                elseif ($row->status == 'rejected'){
                    $label= 'danger';
                }
//                $label = $row->status == 'pending' ? 'warning' : 'success';
                return '<div class="label label-' . $label . '">' . $row->status . '</div>';
            })

            ->addColumn('action', function ($row) {

                return '<a href="javascript:;"
                        data-leave-id=' . $row->id . '
                        class="btn btn-info btn-circle show-leave"
                        data-toggle="tooltip"
                        data-original-title="' . __('app.details') . '">
                            <i class="ti-settings" aria-hidden="true"></i>
                        </a>';
            })
            ->addIndexColumn()
            ->rawColumns(['user',  'status', 'penalty_type', 'action'])
            ->make(true);
    }

    public function create()
    {
        abort_if(!$this->user->cans('add_legalAffairs'),403);

        $this->employees=User::allEmployees();
        $this->clients=User::allClients();
        $this->currencies=Currency::all();
        return view('admin.penalties.create', $this->data);
    }
    public function createEmployeePenalty()
    {
        abort_if(!$this->user->cans('add_legalAffairs'),403);

        $this->employees=User::allEmployees();

        //rola
        //// $this->durations = Penlatyduraton::all();
        $this->durations =PenaltiesDurations::all();

        return view('admin.penalties.create_employee', $this->data);
    }
    public function store(StorePenaltyRequest $request){
        abort_if(!$this->user->cans('add_legalAffairs'),403);

        $penalty= new Penalties();
        if ($request->member_id){
            $member=memberDetails::where('member_id' ,$request->member_id )->first();
            $penalty->user_id=$member->user_id;
            $penalty->status = 'pending';
        }else{
            $member=memberDetails::where('user_id' ,$request->user_id )->first();
            if($request->penalty_type==__('modules.members.suspend_membership') ) {
                $member->status_id = 4;
                $member->save();
            }
            $penalty->user_id=$request->user_id;
            $penalty->status = 'approved';
        }

        $penalty->details=$request->details;
        $penalty->penalty_name=$request->penalty_type;

        
        $penalty->amount=$request->amount;
        $penalty->currency=$request->currency;
       
        //rola
         

        $penalty->save();
        return Reply::redirect(route('admin.penalties.index'));

    }
    public function storeEmployeePenalty(StorePenaltyRequest $request){
        abort_if(!$this->user->cans('add_legalAffairs'),403);
        $penalty= new Penalties();
        $penalty->user_id=$request->employee_id;
        $penalty->status = 'approved';
        $penalty->details=$request->details;
        $penalty->penalty_name=$request->penalty_type;

        // $penalty->details=$request->details;
        // $penalty->penalty_name=$request->penalty_type;

        //rola 
         if($request->penalty_type == 'Deduction'){
            $penalty->amount=$request->duration;
            $penalty->currency=$request->MonthsDays;
          }

         if($request->penalty_type=='Others'){
          $penalty->currency=$request->others_text;
            }
    //    return dd($penalty);


        $penalty->save();
        return Reply::redirect(route('admin.penalties.index'));

    }

public function show($id){
    abort_if(!$this->user->cans('view_legalAffairs'),403);

    $this->penalty = Penalties::findOrFail($id);
    $this->user=User::where('id' , $this->penalty->user_id)->first();
    return view('admin.penalties.show', $this->data);
}
    public function edit($id){
        abort_if(!$this->user->cans('edit_legalAffairs'),403);

        $this->currencies=Currency::all();
        $this->penalty=Penalties::find($id);
        $view = view('admin.penalties.edit', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }
    public function update(Request $request , $id){
        abort_if(!$this->user->cans('edit_legalAffairs'),403);
        $penalty=Penalties::find($id);
        $members=memberDetails::where('user_id' ,$penalty->user_id )->first();
        if($request->penalty_type==__('modules.members.financial_penalty') && $penalty->penalty_name==__('modules.members.suspend_membership') ) {
                $members->status_id = 1;
                $members->save();
        }elseif($penalty->penalty_name==__('modules.members.financial_penalty') && $request->penalty_type==__('modules.members.suspend_membership') ) {
                $members->status_id = 4;
                $members->save();
        }
        $penalty->details=$request->details;
        $penalty->penalty_name=$request->penalty_type;
        $penalty->amount=$request->amount;
        $penalty->currency=$request->currency;
        $penalty->status='pending';

        $penalty->save();
        return Reply::redirect(route('admin.penalties.index'));
    }
    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_legalAffairs'),403);
        $penalty=Penalties::find($id);
        $members=memberDetails::where('user_id' ,$penalty->user_id )->first();
        if($penalty->penalty_name==__('modules.members.suspend_membership') ) {
                $members->status_id = 1;
                $members->save();
        }
        Penalties::destroy($id);
        return Reply::success('messages.Success');
    }




    // public function inputvalue(Request $request)
    // {
    //     $checkHoliday = AreaRent::find('id',$request->date);
    //     // return view('admin.area-rents.index',$this->data)->render();
    //     return Reply::dataOnly(['status' => 'success', 'holiday' => $checkHoliday]);
    // }
}
