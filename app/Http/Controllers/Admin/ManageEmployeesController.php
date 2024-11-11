<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\DataTables\Admin\EmployeesDataTable;
use App\Designation;
use App\EmployeeAssessment;
use App\EmployeeDetails;
use App\EmployeeDocs;
use App\EmployeeLeaveQuota;
use App\EmployeesAssessmentSetting;
use App\EmployeeSkill;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\Admin\Employee\StoreRequest;
use App\Http\Requests\Admin\Employee\UpdateRequest;
use App\Leave;
use App\LeaveType;
use App\Penalties;
use App\Project;
use App\ProjectMember;
use App\ProjectTimeLog;
use App\Role;
use App\RoleUser;
use App\Skill;
use App\Task;
use App\TaskboardColumn;
use App\Team;
use App\UniversalSearch;
use App\User;
use App\UserActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Payroll\Entities\EmployeeMonthlySalary;
use Modules\Payroll\Entities\SalarySlip;
use Yajra\DataTables\Facades\DataTables;

class ManageEmployeesController extends AdminBaseController
{
    use MediaUploadingTrait;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EmployeesDataTable $dataTable)
    {
        $this->employees = User::allEmployees();
        $this->skills = Skill::all();
        $this->departments = Team::all();
        $this->designations = Designation::all();
        $this->totalEmployees = count($this->employees);
        $this->roles = Role::where('roles.name', '<>', 'client')->get();
        $whoseProjectCompleted = ProjectMember::join('projects', 'projects.id', '=', 'project_members.project_id')
            ->join('users', 'users.id', '=', 'project_members.user_id')
            ->select('users.*')
            ->groupBy('project_members.user_id')
            ->havingRaw("min(projects.completion_percent) = 100 and max(projects.completion_percent) = 100")
            ->orderBy('users.id')
            ->get();

        $notAssignedProject = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name')->whereNotIn('users.id', function ($query) {

                $query->select('user_id as id')->from('project_members');
            })
            ->where('roles.name', '<>', 'client')
            ->where('roles.name', '<>', 'member')
            ->get();

        $this->freeEmployees = $whoseProjectCompleted->merge($notAssignedProject)->count();



        // return view('admin.employees.index', $this->data);
        return $dataTable->render('admin.employees.index', $this->data);
    }
    public function EmployeesAssessmentSetting()
    {
        $this->settings=EmployeesAssessmentSetting::whereNotNull('name')->whereNotNull('ass_val')->get();
        return view('admin.employees.set-employees-assessment', $this->data);
    }
    /////// modification from here.

    public function accountNumbersEmployeeReport()
    {
        $now = Carbon::now()->subMonths(1);
        $year = $now->format('Y');
        $month = $now->format('m');
        $content=array();
        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->join('salary_slips', 'salary_slips.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name', 'designations.name as designation_name', 'employee_details.banck_account as banck_account', 'salary_slips.net_salary', 'salary_slips.id as salary_slip_id')
            ->where('roles.name', '<>', 'client')
            ->groupBy('users.id')
            ->orderBy('users.id', 'asc')
            ->get()
            ->makeHidden('unreadNotifications');
        $ind=0;
        foreach ($users as $user) {
            $slip= SalarySlip::where('user_id', $user->role[0]->user_id)->where('month',$month)->where('year',$year)->first();
            $content[$ind]['ind'] = $ind;
            $content[$ind]['ind']=' '.($content[$ind]['ind']+1);
            $content[$ind]['name'] = $user->name;
            $content[$ind]['banck_account'] = $user->banck_account;
            $content[$ind]['designation'] = $user->designation_name;
            if(isset($slip->net_salary)){
                $content[$ind]['Net'] = $slip->net_salary;
            }else{
                $content[$ind]['Net'] = '';
            }
            $ind++;
        }
        $this->contents=$content;
        $this->arabicTitle='كشف المرتبات المحولة بارقام الحساب عن شهر '.__('payroll::modules.mon'.$month).' '.$this->enToAr($year);
        $documentFileName = 'AccountNumbersEmployeeReport.pdf';
        $view = View::make('admin.employees.accountPdf', $this->data);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 8);
        $pdf->SetTitle('Report');
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);
    }

    public function insuredEmployeeAccordingToInsuranceNumberReport()
    {
        $content=array();
        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select(
                'users.id', 
                'users.name', 
                'users.email',
                'designations.name as designation_name',
                'employee_details.insuranceNumber',
                'employee_details.insuranceStartDate',
                'employee_details.joining_date',
                'employee_details.national_id',
                'employee_details.qualification',
                'employee_details.address',
                'employee_details.phone',
                'users.mobile',
                'employee_details.insuranceStatus',
                'employee_details.recruitment_data',
            )
            ->where('roles.name', '<>', 'client')
            ->groupBy('users.id')
            ->orderBy('users.id', 'asc')
            ->get()
            ->makeHidden('unreadNotifications');
        $ind=0;
        foreach ($users as $user) {
            if ($user->insuranceStatus==1){
                $employeeSal=EmployeeMonthlySalary::employeeNetSalary($user->role[0]->user_id);
                $content[$ind]['ind'] = $ind;
                $content[$ind]['ind']=' '.($content[$ind]['ind']+1);
                $content[$ind]['name'] = $user->name;
                $content[$ind]['designation'] = $user->designation_name;
                $content[$ind]['employeeSal'] = $employeeSal['netSalary'];
                $content[$ind]['email'] = $user->email;
                $content[$ind]['recruitment_data'] = $user->recruitment_data;
                $content[$ind]['insuranceNumber'] = $user->insuranceNumber;
                $content[$ind]['insuranceStartDate'] = Carbon::parse($user->insuranceStartDate)->format('Y-m-d');
                $content[$ind]['joining_date'] = Carbon::parse($user->joining_date)->format('Y-m-d');
                $content[$ind]['national_id'] = $user->national_id;
                $content[$ind]['qualification'] = $user->qualification;
                $content[$ind]['address'] = $user->address;
                $content[$ind]['phone'] = $user->phone;
                $content[$ind]['mobile'] = $user->mobile;
                $ind++;
            }
        }
        $this->contents=$content;
        $this->arabicTitle='كشف العاملين المؤمن عليهم طبقا للرقم التاميني';
        $documentFileName = 'insuredEmployeesPdf.pdf';
        $view = View::make('admin.employees.insuredEmployeesPdf', $this->data);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetTitle('Report');
        $pdf->AddPage('L','A4');
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);
    }

    public function insuredEmployeesWithUncasualLeaveBalanceReport($month, $year)
    {
        $content=array();
        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select(
                'users.id', 
                'users.name', 
                'users.email',
                'designations.name as designation_name',
                'employee_details.insuranceNumber',
                'employee_details.insuranceStartDate',
                'employee_details.joining_date',
                'employee_details.national_id',
                'employee_details.insuranceStatus',
            )
            ->where('roles.name', '<>', 'client')
            ->groupBy('users.id')
            ->orderBy('users.id', 'asc')
            ->get()
            ->makeHidden('unreadNotifications');
        $ind=0;
        foreach ($users as $user) {
            if ($user->insuranceStatus==1){
                $content[$ind]['ind'] = $ind;
                $content[$ind]['ind']=' '.($content[$ind]['ind']+1);
                $content[$ind]['name'] = $user->name;
                $content[$ind]['designation'] = $user->designation_name;
                $content[$ind]['insuranceNumber'] = $user->insuranceNumber;
                $content[$ind]['insuranceStartDate'] = Carbon::parse($user->insuranceStartDate)->format('Y-m-d');
                $content[$ind]['joining_date'] = Carbon::parse($user->joining_date)->format('Y-m-d');
                $content[$ind]['national_id'] = $user->national_id;
                $irregular_leave_balance= 6;       //wait to be completed from database setting adding 2column for each emplyee casual and uncasual  updated from cron job
                $content[$ind]['irregular_leave_balance'] = ' '.$irregular_leave_balance;
                $takenCount=0;
                for($monthCount=1; $monthCount < 13; $monthCount++){
                    if($monthCount==1){
                        $startDate = Carbon::create($year,$month,'01')->startOfMonth();
                        $endDate = Carbon::create($year,$month,'01')->endOfMonth();
                    }else{
                        $startDate = Carbon::create($year,$month,'01')->startOfMonth()->subMonth($monthCount);
                        $endDate = Carbon::create($year,$month,'01')->endOfMonth()->subMonth($monthCount);
                    }
                    $leaveInMonth = Leave::countDaysUncasualByUser($startDate, $endDate, $user->id);
                    $content[$ind]['m'.$monthCount] = ' '.$leaveInMonth;
                    $takenCount+=$leaveInMonth;
                }
                $content[$ind]['taken_leaves'] = ' '.$takenCount;
                $content[$ind]['left_leaves'] = ' '.($irregular_leave_balance-$takenCount);
                $ind++;
            }
        }
        for($moCnt=12; $moCnt >0; $moCnt--){
            if($moCnt==1){
                $sDat = Carbon::create($year,$month,'01')->startOfMonth();
            }else{
                $sDat = Carbon::create($year,$month,'01')->startOfMonth()->subMonth($moCnt);
            }
            $monthslabels[$moCnt] = ' '.$sDat->month;
        }
        $this->monthslabels=$monthslabels;
        $this->contents=$content;
        $this->arabicTitle='كشف العاملين المؤمن عليهم برصيد الاجازات العارضة';
        $documentFileName = 'insuredEmployeesWithUncasusalPdf.pdf';
        $view = View::make('admin.employees.insuredEmployeesWithUncasusalPdf', $this->data);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetTitle('Report');
        $pdf->AddPage('L','A4');
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);
    }
    public function insuredEmployeesWithCasualLeaveBalanceReport($month, $year)
    {
        $content=array();
        $users = User::withoutGlobalScope('active')->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->leftJoin('employee_details', 'employee_details.user_id', '=', 'users.id')
            ->leftJoin('designations', 'employee_details.designation_id', '=', 'designations.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'designations.name as designation_name',
                'employee_details.insuranceNumber',
                'employee_details.insuranceStartDate',
                'employee_details.joining_date',
                'employee_details.national_id',
                'employee_details.insuranceStatus',
            )
            ->where('roles.name', '<>', 'client')
            ->groupBy('users.id')
            ->orderBy('users.id', 'asc')
            ->get()
            ->makeHidden('unreadNotifications');
        $ind=0;
        foreach ($users as $user) {
            if ($user->insuranceStatus==1){
                $content[$ind]['ind'] = $ind;
                $content[$ind]['ind']=' '.($content[$ind]['ind']+1);
                $content[$ind]['name'] = $user->name;
                $content[$ind]['designation'] = $user->designation_name;
                $content[$ind]['insuranceNumber'] = $user->insuranceNumber;
                $content[$ind]['insuranceStartDate'] = Carbon::parse($user->insuranceStartDate)->format('Y-m-d');
                $content[$ind]['joining_date'] = Carbon::parse($user->joining_date)->format('Y-m-d');
                $content[$ind]['national_id'] = $user->national_id;
                $regular_leave_balance = 24;  //wait to be completed from database setting adding 2column for each emplyee casual and uncasual  updated from cron job
                $content[$ind]['regular_leave_balance'] = ' '.$regular_leave_balance;
                $takenCount=0;
                for($monthCount=1; $monthCount < 13; $monthCount++){
                    if($monthCount==1){
                        $startDate = Carbon::create($year,$month,'01')->startOfMonth();
                        $endDate = Carbon::create($year,$month,'01')->endOfMonth();
                    }else{
                        $startDate = Carbon::create($year,$month,'01')->startOfMonth()->subMonth($monthCount);
                        $endDate = Carbon::create($year,$month,'01')->endOfMonth()->subMonth($monthCount);
                    }
                    $leaveInMonth = Leave::countDaysCasualByUser($startDate, $endDate, $user->id);
                    $content[$ind]['m'.$monthCount] = ' '.$leaveInMonth;
                    $takenCount+=$leaveInMonth;
                }
                $content[$ind]['taken_leaves'] = ' '.$takenCount;
                $content[$ind]['left_leaves'] = ' '.($regular_leave_balance-$takenCount);
                $ind++;
            }
        }
        for($moCnt=12; $moCnt >0; $moCnt--){
            if($moCnt==1){
                $sDat = Carbon::create($year,$month,'01')->startOfMonth();
            }else{
                $sDat = Carbon::create($year,$month,'01')->startOfMonth()->subMonth($moCnt);
            }
            $monthslabels[$moCnt] = ' '.$sDat->month;
        }
        $this->monthslabels=$monthslabels;
        
        $this->contents=$content;
        $this->arabicTitle='كشف العاملين المؤمن عليهم برصيد الاجازات الاعتيادية';
        $documentFileName = 'insuredEmployeesWithCasusalPdf.pdf';
        $view = View::make('admin.employees.insuredEmployeesWithCasusalPdf', $this->data);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetTitle('Report');
        $pdf->AddPage('L','A4');
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);
    }
    //////// to here
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->employee_id ='';

         if ( EmployeeDetails::latest()->first()) {
            $employee =  EmployeeDetails::max('employee_id') ;
            // $this->employee_id=$employee;

            $string =  EmployeeDetails::max('employee_id') ;

             $replaced = str_replace('EMP', '', $string);
             $replaced=$replaced + 1;
           $this->employee_id='emp-'.$replaced;

            // $employee =  EmployeeDetails::max('employee_id') ;
            // $this->employee_id = 'emp-' . $employee ;
            // $this->employee_id = $employee ;


        }else{
            $this->employee_id = 'emp-1';
        }
        $employee = new EmployeeDetails();
        $this->fields = $employee->getCustomFieldGroupsWithFields()->fields;
        $this->skills = Skill::all()->pluck('name')->toArray();
        $this->teams = Team::all();
        $this->designations = Designation::all();
        $this->lastEmployeeID = EmployeeDetails::count();
        $this->countries = Country::all();

        if (request()->ajax()) {
            return view('admin.employees.ajax-create', $this->data);
        }

        return view('admin.employees.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {

        $company = company();

        if (!is_null($company->employees) && $company->employees->count() >= $company->package->max_employees) {
            return Reply::error(__('messages.upgradePackageForAddEmployees', ['employeeCount' => company()->employees->count(), 'maxEmployees' => $company->package->max_employees]));
        }

        if (!is_null($company->employees) && $company->package->max_employees < $company->employees->count()) {
            return Reply::error(__('messages.downGradePackageForAddEmployees', ['employeeCount' => company()->employees->count(), 'maxEmployees' => $company->package->max_employees]));
        }
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['password'] = Hash::make($request->password);

            if ($request->hasFile('image')) {
                $data['image'] = Files::upload($request->image, 'avatar', 300);
            }
            unset($data['phone_code']);
            $data['country_id'] = $request->input('phone_code');
            if ($request->input('local') != '') {
                $data['locale'] = $request->input('locale');
            } else {
                $data['locale'] = company()->locale;
            }
            $user = User::create($data);
            $landPhoneKey = $request->select_land_phone_code;
            $user->employeeDetail()->create([
                'designation_id'=>$request->designation,
                'employee_id' => $request->employee_id,
                'address' => $request->address,
                'hourly_rate' => $request->hourly_rate,
                'slack_username' => $request->slack_username,
                'joining_date' => Carbon::createFromFormat($this->global->date_format, $request->joining_date)->format('Y-m-d'),
                'last_date' => ($request->last_date != '') ? Carbon::createFromFormat($this->global->date_format, $request->last_date)->format('Y-m-d') : null,
                'department_id' => $request->department,
                'religion' => $request->religion,
                'social_situation' => $request->social_situation,
                'recruitment_data' => $request->recruitment_data,
                'national_id' => $request->national_id,
                'issuance_location' => $request->issuance_location,
                'issuance_data' => $request->issuance_data,
                'banck_account' => $request->banck_account,
                'expiration_date' => $request->expiration_date,
                'insuranceStatus' => $request->insuranceStatus,
                'delegation' => $request->delegation,
                'delegationInstitution' => $request->delegationInstitution,
                'insuranceNumber' => $request->insuranceNumber,
                'insuranceStartDate' => $request->insuranceStartDate,
                'phone' => $landPhoneKey.'-'.$request->land_phone_code,
                'qualification' => $request->qualification,
                //'document' => $request->document,
            ]);

            foreach ($request->input('document', []) as $file) {

                $user->employeeDetail->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
            }


            $tags = json_decode($request->tags);
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    // check or store skills
                    $skillData = Skill::firstOrCreate(['name' => strtolower($tag->value)]);

                    // Store user skills
                    $skill = new EmployeeSkill();
                    $skill->user_id = $user->id;
                    $skill->skill_id = $skillData->id;
                    $skill->save();
                }
            }
            // To add custom fields data
            if ($request->get('custom_fields_data')) {
                $user->employeeDetail->updateCustomFieldData($request->get('custom_fields_data'));
            }

            $role = Role::where('name', 'employee')->first();
            $user->attachRole($role->id);
            DB::commit();
        } catch (\Swift_TransportException $e) {
            DB::rollback();
            return Reply::error('Please configure SMTP details to add employee. Visit Settings -> Email setting to set SMTP', 'smtp_error');
        } catch (\Exception $e) {
            DB::rollback();

            return Reply::error('Some error occured when inserting the data. Please try again or contact support');
        }
        $this->logSearchEntry($user->id, $user->name, 'admin.employees.show', 'employee');

        if ($request->has('ajax_create')) {
            $teams = User::allEmployees();
            $teamData = '';

            foreach ($teams as $team) {
                $teamData .= '<option value="' . $team->id . '"> ' . ucwords($team->name) . ' </option>';
            }

            return Reply::successWithData(__('messages.employeeAdded'), ['teamData' => $teamData]);
        }

        return Reply::redirect(route('admin.employees.index'), __('messages.employeeAdded'));
    }
    public function storeEmployeeSettings(Request $request)
    {
        $arr=array();
        $str='';
        for ($ind=0;$ind<count($request->assessment_name);$ind++){
            $arr[$ind]=[$ind+1, $request->assessment_name[$ind],$request->assessment_value[$ind],null,null];
            if($ind==count($request->assessment_name)-1) {
                $str .= '(?,?,?,?,?)';
            }else{
                $str .= '(?,?,?,?,?),';
            }
           }
        $query = '"insert into employees_assessment_settings values '.$str.' on duplicate key update id = VALUES(id), name = VALUES(name), ass_val = VALUES(ass_val), created_at = VALUES(created_at), updated_at = VALUES(updated_at)"';
        $query = trim($query,'"');
        EmployeesAssessmentSetting::truncate();
        DB::insert($query, array_flatten($arr));


        return Reply::redirect(route('admin.employees.index'), __('messages.settingsUpdated'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department', 'leaveTypes'])->withoutGlobalScope('active')->findOrFail($id);
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->employee->id)->first();
        $this->employeeDocs = EmployeeDocs::where('user_id', '=', $this->employee->id)->get();
        if (!is_null($this->employeeDetail)) {
            $this->employeeDetail = $this->employeeDetail->withCustomFields();
            $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $completedTaskColumn = TaskboardColumn::where('slug', 'completed')->first();

        $this->taskCompleted = Task::join('task_users', 'task_users.task_id', '=', 'tasks.id')
            ->where('task_users.user_id', $id)
            ->where('tasks.board_column_id', $completedTaskColumn->id)
            ->count();

        $hoursLogged = ProjectTimeLog::where('user_id', $id)->sum('total_minutes');

        $timeLog = intdiv($hoursLogged, 60) . ' hrs ';

        if (($hoursLogged % 60) > 0) {
            $timeLog .= ($hoursLogged % 60) . ' mins';
        }

        $this->hoursLogged = $timeLog;

        $this->activities = UserActivity::where('user_id', $id)->orderBy('id', 'desc')->get();
        $this->projects = Project::select('projects.id', 'projects.project_name', 'projects.deadline', 'projects.completion_percent')
            ->join('project_members', 'project_members.project_id', '=', 'projects.id')
            ->where('project_members.user_id', '=', $id)
            ->get();
        $this->leaves = Leave::byUser($id);
        $this->leavesCount = Leave::byUserCount($id);
        $this->Penalties=Penalties::where('user_id',$id)->get();
        $this->salary = EmployeeMonthlySalary::where('user_id',$id)->where('type','initial')->get();
        $this->deductions = EmployeeMonthlySalary::where('user_id',$id)->where('type','decrement')->get();
        $this->bounses = EmployeeMonthlySalary::where('user_id',$id)->where('type','increment')->get();
        $grantsQuery = SalarySlip::where('user_id',$id)->whereNotNull('extra_json')->get();
        $arr=array();
        if($grantsQuery){
            $ind=1;
            foreach ($grantsQuery as $grant){
                foreach (json_decode($grant->extra_json) as $key=>$value){
                    //return dd($key);
                    foreach ($value as $keyin=>$valuein){
                        //return dd($keyin);
                        //return dd($valuein);
                        array_push($arr,['no'=>$ind, 'type'=>$key,'name'=>$keyin,'amount'=>$valuein, 'date'=>$grant->created_at]);
                        $ind++;
                    }
                }
            }
        }
        $this->grants=$arr;
        $this->leaveTypes = LeaveType::byUser($id);
        $this->assessments=EmployeeAssessment::where('user_id',$id)->get();
        $this->allowedLeaves = $this->employee->leaveTypes->sum('no_of_leaves');
        $this->employeeLeavesQuota = $this->employee->leaveTypes;

        return view('admin.employees.show', $this->data);
    }
    function enToAr($string) {
        return strtr($string, array('0'=>'٠','1'=>'١','2'=>'٢','3'=>'٣','4'=>'٤','5'=>'٥','6'=>'٦','7'=>'٧','8'=>'٨','9'=>'٩'));
    }
    public function downloadStatusInfo($id)
    {
        $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department', 'leaveTypes'])->withoutGlobalScope('active')->findOrFail($id);
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->employee->id)->first();
        $this->employeeDocs = EmployeeDocs::where('user_id', '=', $this->employee->id)->get();
        if (!is_null($this->employeeDetail)) {
            $this->employeeDetail = $this->employeeDetail->withCustomFields();
            $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
        }

        $completedTaskColumn = TaskboardColumn::where('slug', 'completed')->first();

        $this->taskCompleted = Task::join('task_users', 'task_users.task_id', '=', 'tasks.id')
            ->where('task_users.user_id', $id)
            ->where('tasks.board_column_id', $completedTaskColumn->id)
            ->count();

        $hoursLogged = ProjectTimeLog::where('user_id', $id)->sum('total_minutes');

        $timeLog = intdiv($hoursLogged, 60) . ' hrs ';

        if (($hoursLogged % 60) > 0) {
            $timeLog .= ($hoursLogged % 60) . ' mins';
        }

        $this->hoursLogged = $timeLog;

        $this->activities = UserActivity::where('user_id', $id)->orderBy('id', 'desc')->get();
        $this->projects = Project::select('projects.id', 'projects.project_name', 'projects.deadline', 'projects.completion_percent')
            ->join('project_members', 'project_members.project_id', '=', 'projects.id')
            ->where('project_members.user_id', '=', $id)
            ->get();
        $this->leaves = Leave::byUser($id);
        $this->leavesCount = Leave::byUserCount($id);
        $this->Penalties=Penalties::where('user_id',$id)->get();
        $this->salary = EmployeeMonthlySalary::where('user_id',$id)->where('type','initial')->get();
        $this->deductions = EmployeeMonthlySalary::where('user_id',$id)->where('type','decrement')->get();
        $this->bounses = EmployeeMonthlySalary::where('user_id',$id)->where('type','increment')->get();
        $grantsQuery = SalarySlip::where('user_id',$id)->whereNotNull('extra_json')->get();
        $arr=array();
        if($grantsQuery){
            $ind=1;
            foreach ($grantsQuery as $grant){
                foreach (json_decode($grant->extra_json) as $key=>$value){
                    //return dd($key);
                    foreach ($value as $keyin=>$valuein){
                        //return dd($keyin);
                        //return dd($valuein);
                        array_push($arr,['no'=>$ind, 'type'=>$key,'name'=>$keyin,'amount'=>$valuein, 'date'=>$grant->created_at]);
                        $ind++;
                    }
                }
            }
        }
        $this->date = Carbon::now()->format('d-m-Y');
        $this->grants=$arr;
        $this->leaveTypes = LeaveType::byUser($id);
        $this->assessments=EmployeeAssessment::where('user_id',$id)->get();
        $this->allowedLeaves = $this->employee->leaveTypes->sum('no_of_leaves');
        $this->employeeLeavesQuota = $this->employee->leaveTypes;
        $documentFileName = 'Employee Status.pdf';
        $view = View::make('admin.employees.downloadStatusInfo',$this->data);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetTitle('Report');
        $pdf->AddPage();
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->userDetail = User::withoutGlobalScope('active')->findOrFail($id);
        $this->employeeDetail = EmployeeDetails::where('user_id', '=', $this->userDetail->id)->first();
        $this->skills = Skill::all()->pluck('name')->toArray();
        $this->teams = Team::all();
        $this->designations = Designation::all();
        $arr = explode("-", $this->employeeDetail->phone, 2);
        $this->select_land_phone_code = $arr[0];
        $this->land_phone_code = $arr[1]??'';
        $this->countries = Country::all();
        if (!is_null($this->employeeDetail)) {
            $this->employeeDetail = $this->employeeDetail->withCustomFields();
            $this->fields = $this->employeeDetail->getCustomFieldGroupsWithFields()->fields;
        }


        return view('admin.employees.edit', $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return array
     */
    public function update(UpdateRequest $request, $id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->locale = $request->input('locale');
        if ($request->password != '') {
            $user->password = Hash::make($request->input('password'));
        }
        $user->mobile = $request->input('mobile');
        $user->country_id = $request->input('phone_code');
        $user->gender = $request->input('gender');
        $user->status = $request->input('status');
        $user->login = $request->login;
        $user->email_notifications = $request->email_notifications;

        if ($request->hasFile('image')) {
            $user->image = Files::upload($request->image, 'avatar', 300);
        }

        $user->save();

        $tags = json_decode($request->tags);
        if (!empty($tags)) {
            EmployeeSkill::where('user_id', $user->id)->delete();
            foreach ($tags as $tag) {
                // check or store skills
                $skillData = Skill::firstOrCreate(['name' => strtolower($tag->value)]);

                // Store user skills
                $skill = new EmployeeSkill();
                $skill->user_id = $user->id;
                $skill->skill_id = $skillData->id;
                $skill->save();
            }
        }
        $employee = EmployeeDetails::where('user_id', '=', $user->id)->first();
        if (empty($employee)) {
            $employee = new EmployeeDetails();
            $employee->user_id = $user->id;
        }
        $employee->employee_id = $request->employee_id;
        $landPhoneKey = $request->select_land_phone_code;
        $employee->phone = $landPhoneKey.'-'.$request->land_phone_code;
        $employee->banck_account =$request->banck_account;
        $employee->qualification_data =$request->qualification_data;
        $employee->address = $request->address;
        $employee->hourly_rate = $request->hourly_rate;
        $employee->slack_username = $request->slack_username;
        $employee->joining_date = Carbon::createFromFormat($this->global->date_format, $request->joining_date)->format('Y-m-d');

        $employee->last_date = null;

        if ($request->last_date != '') {
            $employee->last_date = Carbon::createFromFormat($this->global->date_format, $request->last_date)->format('Y-m-d');
        }

        $employee->department_id = $request->department;
        $employee->designation_id = $request->designation;
        $employee->religion = $request->religion;
        $employee->social_situation = $request->social_situation;
        $employee->recruitment_data = $request->recruitment_data;
        $employee->national_id = $request->national_id;
        $employee->issuance_location = $request->issuance_location;
        $employee->issuance_data = $request->issuance_data;
        $employee->expiration_date = $request->expiration_date;
        $employee->qualification = $request->qualification;
        $employee->insuranceStatus =$request->insuranceStatus;
        $employee->delegation =$request->delegation;
        $employee->delegationInstitution =$request->delegationInstitution;
        $employee->insuranceNumber =$request->insuranceNumber;
        $employee->insuranceStartDate =$request->insuranceStartDate;
        $employee->save();


        if (count($employee->document) > 0) {
            foreach ($employee->document as $media) {
                if (!in_array($media->file_name, $request->input('document', []))) {
                    $media->delete();
                }
            }
        }

        $media = $employee->document->pluck('file_name')->toArray();


        foreach ($request->input('document', []) as $file){
            if (count($media) === 0 || !in_array($file, $media)) {
                $employee->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('document');
            }
        }

        // To add custom fields data
        if ($request->get('custom_fields_data')) {
            $employee->updateCustomFieldData($request->get('custom_fields_data'));
        }

        session()->forget('user');

        return Reply::redirect(route('admin.employees.index'), __('messages.employeeUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withoutGlobalScope('active')->findOrFail($id);

        if ($user->id == 1) {
            return Reply::error(__('messages.adminCannotDelete'));
        }

        $universalSearches = UniversalSearch::where('searchable_id', $id)->where('module_type', 'employee')->get();
        if ($universalSearches) {
            foreach ($universalSearches as $universalSearch) {
                UniversalSearch::destroy($universalSearch->id);
            }
        }
        User::destroy($id);

        session()->forget('company_setting');
        session()->forget('company');
        $this->employees = User::allEmployees();
        $this->totalEmployees = count($this->employees);
        $whoseProjectCompleted = ProjectMember::join('projects', 'projects.id', '=', 'project_members.project_id')
            ->join('users', 'users.id', '=', 'project_members.user_id')
            ->select('users.*')
            ->groupBy('project_members.user_id')
            ->havingRaw("min(projects.completion_percent) = 100 and max(projects.completion_percent) = 100")
            ->orderBy('users.id')
            ->get();

        $notAssignedProject = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.id', 'users.name')->whereNotIn('users.id', function ($query) {

                $query->select('user_id as id')->from('project_members');
            })
            ->where('roles.name', '<>', 'client')
            ->where('roles.name', '<>', 'member')
            ->get();

        $this->freeEmployees = $whoseProjectCompleted->merge($notAssignedProject)->count();
        return Reply::successWithData(__('messages.employeeDeleted'), ['data' => $this->data]);
    }

    public function tasks($userId, $hideCompleted)
    {
        $taskBoardColumn = TaskboardColumn::where('slug', 'incomplete')->first();

        $tasks = Task::join('task_users', 'task_users.task_id', '=', 'tasks.id')
            ->leftJoin('projects', 'projects.id', '=', 'tasks.project_id')
            ->join('taskboard_columns', 'taskboard_columns.id', '=', 'tasks.board_column_id')
            ->select('tasks.id', 'projects.project_name', 'tasks.heading', 'tasks.due_date', 'tasks.status', 'tasks.project_id', 'taskboard_columns.column_name', 'taskboard_columns.label_color')
            ->where('task_users.user_id', $userId);

        if ($hideCompleted == '1') {
            $tasks->where('tasks.board_column_id', $taskBoardColumn->id);
        }

        $tasks->get();

        return DataTables::of($tasks)
            ->editColumn('due_date', function ($row) {
                if (!is_null($row->due_date)) {
                    if ($row->due_date->isPast()) {
                        return '<span class="text-danger">' . $row->due_date->format($this->global->date_format) . '</span>';
                    }
                    return '<span class="text-success">' . $row->due_date->format($this->global->date_format) . '</span>';
                }

            })
            ->editColumn('heading', function ($row) {
                $name = '<a href="javascript:;" data-task-id="' . $row->id . '" class="show-task-detail">' . ucfirst($row->heading) . '</a>';

                if ($row->is_private) {
                    $name .= ' <i data-toggle="tooltip" data-original-title="' . __('app.private') . '" class="fa fa-lock" style="color: #ea4c89"></i>';
                }
                return $name;
            })
            ->editColumn('column_name', function ($row) {
                return '<label class="label" style="background-color: ' . $row->label_color . '">' . $row->column_name . '</label>';
            })
            ->editColumn('project_name', function ($row) {
                if (!is_null($row->project_name)) {
                    return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
                }
            })
            ->rawColumns(['column_name', 'project_name', 'due_date', 'heading'])
            ->removeColumn('project_id')
            ->make(true);
    }

    public function timeLogs($userId)
    {
        $timeLogs = ProjectTimeLog::join('projects', 'projects.id', '=', 'project_time_logs.project_id')
            ->select('project_time_logs.id', 'projects.project_name', 'project_time_logs.start_time', 'project_time_logs.end_time', 'project_time_logs.total_hours', 'project_time_logs.memo', 'project_time_logs.project_id', 'project_time_logs.total_minutes')
            ->where('project_time_logs.user_id', $userId);
        $timeLogs->get();

        return DataTables::of($timeLogs)
            ->editColumn('start_time', function ($row) {
                return $row->start_time->timezone($this->global->timezone)->format($this->global->date_format . ' ' . $this->global->time_format);
            })
            ->editColumn('end_time', function ($row) {
                if (!is_null($row->end_time)) {
                    return $row->end_time->timezone($this->global->timezone)->format($this->global->date_format . ' ' . $this->global->time_format);
                } else {
                    return "<label class='label label-success'>Active</label>";
                }
            })
            ->editColumn('project_name', function ($row) {
                return '<a href="' . route('admin.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
            })
            ->editColumn('total_hours', function ($row) {
                $timeLog = intdiv($row->total_minutes, 60) . ' hrs ';

                if (($row->total_minutes % 60) > 0) {
                    $timeLog .= ($row->total_minutes % 60) . ' mins';
                }

                return $timeLog;
            })
            ->rawColumns(['end_time', 'project_name'])
            ->removeColumn('project_id')
            ->make(true);
    }

    public function export($status, $employee, $role)
    {
        if ($role != 'all' && $role != '') {
            $userRoles = Role::findOrFail($role);
        }
        $designations_name = 'designations.name';

        $rows = User::join('role_user', 'role_user.user_id', '=', 'users.id')
            ->withoutGlobalScope('active')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->where('roles.name', '<>', 'client')
            ->leftJoin('employee_details', 'users.id', '=', 'employee_details.user_id')
            ->leftJoin('designations', 'designations.id', '=', 'employee_details.designation_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.mobile',
                $designations_name.' as designation_name',
                'employee_details.address',
                'employee_details.hourly_rate',
                'users.created_at',
                'roles.name as roleName'
            );
        if ($status != 'all' && $status != '') {
            $rows = $rows->where('users.status', $status);
        }

        if ($employee != 'all' && $employee != '') {
            $rows = $rows->where('users.id', $employee);
        }

        if ($role != 'all' && $role != '' && $userRoles) {
            if ($userRoles->name == 'admin') {
                $rows = $rows->where('roles.id', $role);
            } elseif ($userRoles->name == 'employee') {
                $rows = $rows->where(\DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1)"), $role)
                    ->having('roleName', '<>', 'admin');
            } else {
                $rows = $rows->where(\DB::raw("(select user_roles.role_id from role_user as user_roles where user_roles.user_id = users.id ORDER BY user_roles.role_id DESC limit 1)"), $role);
            }
        }
        $attributes = ['roleName'];
        $rows = $rows->groupBy('users.id')->get()->makeHidden($attributes);

        // Initialize the array which will be passed into the Excel
        // generator.
        $exportArray = [];

        // Define the Excel spreadsheet headers
        $exportArray[] = ['ID', 'Name', 'Email', 'Mobile', 'Designation', 'Address', 'Hourly Rate', 'Created at', 'Role'];

        // Convert each member of the returned collection into an array,
        // and append it to the payments array.
        foreach ($rows as $row) {
            $exportArray[] = [
                "id" => $row->id,
                "name" => $row->name,
                "email" => $row->email,
                "mobile" => $row->mobile,
                "Designation" => $row->designation_name,
                "address" => $row->address,
                "hourly_rate" => $row->hourly_rate,
                "created_at" => $row->created_at->format('Y-m-d h:i:s a'),
                "roleName" => $row->roleName
            ];
        }

        // Generate and return the spreadsheet
        Excel::create('Employees', function ($excel) use ($exportArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Employees');
            $excel->setCreator('Worksuite')->setCompany($this->companyName);
            $excel->setDescription('Employees file');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function ($sheet) use ($exportArray) {
                $sheet->fromArray($exportArray, null, 'A1', false, false);

                $sheet->row(1, function ($row) {

                    // call row manipulation methods
                    $row->setFont(array(
                        'bold' => true
                    ));
                });
            });
        })->download('xlsx');
    }

    public function assignRole(Request $request)
    {
        $userId = $request->userId;
        $roleId = $request->role;
        $employeeRole = Role::where('name', 'employee')->first();
        $user = User::withoutGlobalScope('active')->findOrFail($userId);

        RoleUser::where('user_id', $user->id)->delete();
        $user->roles()->attach($employeeRole->id);
        if ($employeeRole->id != $roleId) {
            $user->roles()->attach($roleId);
        }

        return Reply::success(__('messages.roleAssigned'));
    }

    public function assignProjectAdmin(Request $request)
    {
        $userId = $request->userId;
        $projectId = $request->projectId;
        $project = Project::findOrFail($projectId);
        $project->project_admin = $userId;
        $project->save();

        return Reply::success(__('messages.roleAssigned'));
    }

    public function docsCreate(Request $request, $id)
    {
        $this->employeeID = $id;
        $this->upload = can_upload();
        return view('admin.employees.docs-create', $this->data);
    }

    public function freeEmployees()
    {
        if (\request()->ajax()) {

            $whoseProjectCompleted = ProjectMember::join('projects', 'projects.id', '=', 'project_members.project_id')
                ->join('users', 'users.id', '=', 'project_members.user_id')
                ->select('users.*')
                ->groupBy('project_members.user_id')
                ->havingRaw("min(projects.completion_percent) = 100 and max(projects.completion_percent) = 100")
                ->orderBy('users.id')
                ->get();

            $notAssignedProject = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.*')
                ->whereNotIn('users.id', function ($query) {

                    $query->select('user_id as id')->from('project_members');
                })
                ->where('roles.name', '<>', 'client')
                ->where('roles.name', '<>', 'member')

                ->get();

            $freeEmployees = $whoseProjectCompleted->merge($notAssignedProject);

            return DataTables::of($freeEmployees)
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.employees.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                      data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                      <a href="' . route('admin.employees.show', [$row->id]) . '" class="btn btn-success btn-circle"
                      data-toggle="tooltip" data-original-title="View Employee Details"><i class="fa fa-search" aria-hidden="true"></i></a>

                      <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></a>';
                })
                ->editColumn(
                    'created_at',
                    function ($row) {
                        return Carbon::parse($row->created_at)->format($this->global->date_format);
                    }
                )
                ->editColumn(
                    'status',
                    function ($row) {
                        if ($row->status == 'active') {
                            return '<label class="label label-success">' . __('app.active') . '</label>';
                        } else {
                            return '<label class="label label-danger">' . __('app.inactive') . '</label>';
                        }
                    }
                )
                ->editColumn('name', function ($row) {
                    $image = '<img src="' . $row->image_url . '" alt="user" class="img-circle" width="30" height="30"> ';
                    return '<a href="' . route('admin.employees.show', $row->id) . '">' . $image . ' ' . ucwords($row->name) . '</a>';
                })
                ->rawColumns(['name', 'action', 'role', 'status'])
                ->removeColumn('roleId')
                ->removeColumn('roleName')
                ->removeColumn('current_role')
                ->make(true);
        }

        return view('admin.employees.free_employees', $this->data);
    }

    public function leaveTypeEdit($id)
    {
        $this->employeeLeavesQuota = User::with('leaveTypes', 'leaveTypes.leaveType')->withoutGlobalScope('active')->findOrFail($id)->leaveTypes;
        return view('admin.employees.leave_type_edit', $this->data);
    }

    public function leaveTypeUpdate(Request $request, $id)
    {
        if ($request->leaves < 0) {
            return Reply::error('messages.leaveTypeValueError');
        }
        $type = EmployeeLeaveQuota::findOrFail($id);
        $type->no_of_leaves = $request->leaves;
        $type->save();

        session()->forget('user');

        return Reply::success(__('messages.leaveTypeAdded'));
    }


}
