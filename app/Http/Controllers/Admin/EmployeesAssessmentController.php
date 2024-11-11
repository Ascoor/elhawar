<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\EmployeesAssessmentDataTable;
use App\EmployeeAssessment;
use App\EmployeesAssessmentSetting;
use App\Helper\Reply;
use App\Http\Requests\EmpolyeeAssessmentRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeesAssessmentController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.employees';
        $this->pageIcon = 'icon-user';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('employees', $this->user->modules), 403);
            return $next($request);
        });
    }

    public function index(EmployeesAssessmentDataTable $dataTable)
    {
        $this->employees = User::allEmployees();
        $this->totalAssessments =EmployeeAssessment::all()->count();
        $this->assessments =EmployeeAssessment::all();
        return $dataTable->render('admin.employees.employee-assessment', $this->data);
    }
    public function create()
    {
        $this->employees=User::allEmployees();
        $this->settings=EmployeesAssessmentSetting::whereNotNull('name')->whereNotNull('ass_val')->get();
        return view('admin.employees.create-employee-assessment', $this->data);
    }
    public function store(EmpolyeeAssessmentRequest $request){
        $length = count($request->assessment_name);
        $arr=array();
        for($ind=0;$ind<$length;$ind++){
            $arr[$ind]=[
                'name'=>$request->assessment_name[$ind],
                'assessment'=>$request->assessment_value[$ind],
                'final_degree'=>$request->assessment_value_hidden[$ind]
            ];
        }
        $extra_json= json_encode($arr);
        $date = Carbon::now()->format('Y-m-d');
        $user=User::find($request->user_id);
        EmployeeAssessment::create(
            [
                'user_id'=>$request->user_id,
                'name'=>$request->ass_name,
                'employee_name'=>$user->name,
                'status'=>'pending',
                'opinion1'=>$request->direct_manager_opinion,
                'opinion2'=>'',
                'opinion3'=>'',
                'date'=>$date,
                'assessment_percentage'=>$request->perc_input,
                'extra_json'=>$extra_json,
            ]);
        return Reply::redirect(route('admin.employees.assessments.index'), __('messages.createSuccess'));
    }
    public function destroy($id)
    {
        $del= EmployeeAssessment::find($id);
        $del->delete();
        return Reply::success(__('messages.deleteSuccess'));
    }
    public function edit($id)
    {
        $this->assessment= EmployeeAssessment::find($id);
        $this->employees=User::allEmployees();
        $this->settings=json_decode($this->assessment->extra_json);
        $this->total_final_degree=0;
        $this->total_assessments=0;
        foreach ($this->settings as $set){
            $this->total_final_degree += $set->final_degree;
            $this->total_assessments += $set->assessment;
        }
        return view('admin.employees.edit-employee-assessment', $this->data);
    }
    public function update(EmpolyeeAssessmentRequest $request, $id){
        $length = count($request->assessment_name);
        $arr=array();
        for($ind=0;$ind<$length;$ind++){
            $arr[$ind]=[
                'name'=>$request->assessment_name[$ind],
                'assessment'=>$request->assessment_value[$ind],
                'final_degree'=>$request->assessment_value_hidden[$ind]
            ];
        }
        $extra_json= json_encode($arr);
        $date = Carbon::now()->format('Y-m-d');
        $user=User::find($request->user_id);
        $assessment_record=EmployeeAssessment::find($id);
        $assessment_record->user_id=$request->user_id;
        $assessment_record->name=$request->ass_name;
        $assessment_record->employee_name=$user->name;
        $assessment_record->status='pending';
        $assessment_record->opinion1=$request->direct_manager_opinion;
        $assessment_record->opinion2='';
        $assessment_record->opinion3='';
        $assessment_record->date=$date;
        $assessment_record->assessment_percentage=$request->perc_input;
        $assessment_record->extra_json=$extra_json;
        $assessment_record->save();
        return Reply::redirect(route('admin.employees.assessments.index'), __('messages.createSuccess'));
    }
}
