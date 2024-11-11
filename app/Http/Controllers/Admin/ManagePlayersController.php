<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\ClientSubCategory;
use App\ContractType;
use App\Country;
use App\DataTables\Admin\PlayersDataTable;
use App\DataTables\Admin\TeamPlayersDataTable;
use App\Helper\Reply;
use App\Holiday;
use App\memberCategory;
use App\memberDetails;
use App\Player;
use App\memberRelations;
use App\memberStatus;
use App\Project;
use App\sports;
use App\SportAcademy;
use App\sportsTeams;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\member\StorePlayerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\Player\PlayerRequest;

class ManagePlayersController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.members';
        $this->pageIcon = 'icon-people';
     
    }
    public function index(PlayersDataTable $dataTable)
    {

        $this->player = Player::all();
        $this->totalmembers = count($this->player);
        $this->countries = Country::all();
        $this->teams=sports::all();
        $this->acdemy = SportAcademy::all();

        // dd($this->player);
        // return $this->player;

        return $dataTable->render('admin.players.index', $this->data);
    }
    public function create()
    {
        abort_if(!$this->user->cans('add_players'),403);

        $this->member_id=null;
        if (Player::latest()->first()) {
            $this->player_id = Player::latest()->first()->player_id + 1;
        }
        else{
            $this->player_id =1;
        }

        $this->status = memberStatus::all();
        $this->countries = Country::all();
        $this->sports = sports::all();
        $this->acdemy = SportAcademy::all();
        $this->teams = sportsTeams::all();
        $this->relations = memberRelations::where('id', '1')->get();
        return view('admin.players.create', $this->data );
    }

    public function store(StorePlayerRequest $request)
    {
        
        abort_if(!$this->user->cans('add_sportTeams'),403);

        $player = new Player();
        $player->player_id = $request->input('player_id');
        $player->union_id = $request->input('union_id');
        $player->name = $request->salutation . " " . $request->input('name');
        $player->national_id = $request->input('national_id');
        $player->sports_id = $request->input('sports_id');
        $player->academy_id = $request->input('academy_id');
        $player->team_id = $request->input('team_id');
        $player->kind = $request->input('kind');
        $player->gender = $request->input('gender');

        $birth = $request->input('date_of_birth');
        $formatted_birth = Carbon::parse($birth)->format('Y-m-d');
        $player->date_of_birth = $formatted_birth;

        $date = $request->input('date_status');
        $formatted_date_status = Carbon::parse($date)->format('Y-m-d');
        $player->date_status = $formatted_date_status;

        $player->belt = $request->input('belt');
        $player->level = $request->input('level');
        $player->stars = $request->input('stars');
        $player->weight = $request->input('weight');
        $player->height = $request->input('height');
        
        $player->age = $request->input('age');
        $player->city = $request->input('city');
        $player->status_player = $request->input('status_player');
        $player->club_name = $request->input('club_name');
        $player->champions_award = $request->input('champions_award');
        $player->address = $request->input('address');
        $player->country_id = $request->input('country_id');
        $player->mobile = $request->input('mobile');
        $player->guardian_mobile = $request->input('guardian_mobile');
        $player->note = $request->input('note');
        $player->save();
        return Reply::redirect(route('admin.players.index'));
    }

    public function edit($id)
    {
        abort_if(!$this->user->cans('edit_players'),403);

        $this->playerDetail = Player::where('id', '=', $id)->first();
        $this->status = memberStatus::all();
        $this->countries = Country::all();
        $this->sports = sports::all();
        $this->acdemy = SportAcademy::all();
        $this->teams = sportsTeams::all();
        $this->relations = memberRelations::where('id', '1')->get();

        
        return view('admin.players.edit', $this->data);

    }

    public function update(Request $request, $id)
    {
        abort_if(!$this->user->cans('edit_players'), 403);

        $player = Player::find($id);

        $player->player_id = $request->input('player_id');
        $player->union_id = $request->input('union_id');
        $player->name = $request->salutation . " " . $request->input('name');
        $player->national_id = $request->input('national_id');
        $player->academy_id = $request->input('academy_id');
        $player->sports_id = $request->input('sports_id');
        $player->team_id = $request->input('team_id');
        $player->kind = $request->input('kind');
        $player->gender = $request->input('gender');

        $birth = $request->input('date_of_birth');
        $formatted_birth = Carbon::parse($birth)->format('Y-m-d');
        $player->date_of_birth = $formatted_birth;

        $date = $request->input('date_status');
        $formatted_date_status = Carbon::parse($date)->format('Y-m-d');
        $player->date_status = $formatted_date_status;
        
        $player->belt = $request->input('belt');
        $player->level = $request->input('level');
        $player->stars = $request->input('stars');
        $player->weight = $request->input('weight');
        $player->height = $request->input('height');
        
        $player->age = $request->input('age');
        $player->city = $request->input('city');
        $player->status_player = $request->input('status_player');
        $player->club_name = $request->input('club_name');
        $player->champions_award = $request->input('champions_award');
        $player->address = $request->input('address');
        $player->country_id = $request->input('country_id');
        $player->mobile = $request->input('mobile');
        $player->guardian_mobile = $request->input('guardian_mobile');
        $player->note = $request->input('note');
        
        $player->update();
       

        return Reply::redirect(route('admin.players.index'));
    }


    public function storeFromMember($id)
    {
        abort_if(!$this->user->cans('edit_players'),403);
    $this->userDetail = memberDetails::join('users', 'member_details.user_id', '=', 'users.id')
        ->where('member_details.member_id', $id)
        ->select(
            'member_details.id', 
            'member_details.name', 
            'member_details.email', 
            'member_details.user_id', 
            'member_details.phone', 
            'member_details.national_id', 
            'member_details.age', 
            'member_details.city', 
            'member_details.address', 
            'users.locale', 
            'users.status', 
            'users.login')
        ->first();



        $this->member_id=null;
        if (Player::latest()->first()) {
            $this->player_id = Player::latest()->first()->player_id + 1;
        }
        else{
            $this->player_id =1;
        }

        $this->status = memberStatus::all();
        $this->countries = Country::all();
        $this->sports = sports::all();
        $this->acdemy = SportAcademy::all();
        $this->teams = sportsTeams::all();
        $this->relations = memberRelations::where('id', '1')->get();

        return view('admin.players.member_as_player', $this->data);

    }

    

    // public function update(Request $request , $id){
    //     $member=memberDetails::find($id);
    //     $member->player=1;
    //     $member->team_id=$request->team_id;
    //     $member->save();
    //     return Reply::redirect(route('admin.players.index'));

    // }

    // public function edit($id)
    // {
    //     abort_if(!$this->user->cans('edit_players'),403);
    //     $this->userDetail = Player::find($id);
        
    //     $this->countries = Country::all();
    //     $this->sports = sports::all();
    //     $this->acdemy = SportAcademy::all();
    //     $this->teams = sportsTeams::all();
    //     $this->relations = memberRelations::where('id', '1')->get();

    //     return view('admin.players.edit', $this->data);

    // }



    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_members'), 403);

        $player = Player::find($id);
        if ($player->relation_id == 1) {
            $family = $player->family();
            foreach ($family as $f_member) {
                $f_user = memberDetails::where('id', $f_member->id)->first();
                $f_user->delete();
                $f_member->delete();
            }

        } else {
            $member = memberDetails::where('id', $id)->first();
            $member->delete();
            $player->delete();
        }
        return Reply::success(__('messages.memberDeleted'));
    }




    public function createFromMember(){
        abort_if(!$this->user->cans('add_players'),403);

//        $this->members=memberDetails::where('player' , null)->limit(1)->get();
        return view('admin.players.create_from_member', $this->data );
    }
    public function playersSummary()
    {
        abort_if(!$this->user->cans('view_players'),403);

       return $this->employees = memberDetails::where('player' , 1)->get();
        $this->teams = sports::all();
        $now = Carbon::now();
        $this->year = $now->format('Y');
        $this->month = $now->format('m');

        return view('admin.players.players_attendance', $this->data);
    }
    public function playersSummaryData(Request $request)
    {
        abort_if(!$this->user->cans('view_players'),403);

        $employees = User::with(
            ['attendance' => function ($query) use ($request) {
                $query->whereRaw('MONTH(attendances.clock_in_time) = ?', [$request->month])
                    ->whereRaw('YEAR(attendances.clock_in_time) = ?', [$request->year]);
            }]
        )->join('role_user', 'role_user.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->join('member_details' , 'member_details.user_id' , '=' , 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.created_at', 'users.image' , 'member_details.team_id')
            ->where('roles.name', '=', 'member')
            ->where('member_details.player' , '=' , 1)->groupBy('users.id');
        if ($request->userId != '0') {
            $employees = $employees->where('users.id', $request->userId);
        }
        if ($request->team_id != '0'){
            $employees = $employees->where('member_details.team_id', '=' ,$request->team_id);
        }
        $employees = $employees->get();



        $this->holidays = Holiday::whereRaw('MONTH(holidays.date) = ?', [$request->month])->whereRaw('YEAR(holidays.date) = ?', [$request->year])->get();

        $final = [];

        $this->daysInMonth = Carbon::parse('01-' . $request->month . '-' . $request->year)->daysInMonth;
        $month = Carbon::parse('01-' . $request->month . '-' . $request->year)->lastOfMonth();
        $now = Carbon::now()->timezone($this->global->timezone);
        $requestedDate = Carbon::parse(Carbon::parse('01-' . $request->month . '-' . $request->year))->endOfMonth();

        foreach ($employees as $employee) {

            if($requestedDate->isPast()){
                $dataTillToday = array_fill(1, $this->daysInMonth, 'Absent');
            }
            else{
                $dataTillToday = array_fill(1, $now->copy()->format('d'), 'Absent');
            }

            $dataFromTomorrow = [];
            if (($now->copy()->addDay()->format('d') != $this->daysInMonth) && !$requestedDate->isPast()) {
                $dataFromTomorrow = array_fill($now->copy()->addDay()->format('d'), ($this->daysInMonth - $now->copy()->format('d')), '-');
            } else {
                if($this->daysInMonth < $now->copy()->format('d')){
                    $dataFromTomorrow = array_fill($month->copy()->addDay()->format('d'), (0), 'Absent');
                }
                else{
                    $dataFromTomorrow = array_fill($month->copy()->addDay()->format('d'), ($this->daysInMonth - $now->copy()->format('d')), 'Absent');
                }
            }
            $final[$employee->id . '#' . $employee->name] = array_replace($dataTillToday, $dataFromTomorrow);

            foreach ($employee->attendance as $attendance) {
                $final[$employee->id . '#' . $employee->name][Carbon::parse($attendance->clock_in_time)->timezone($this->global->timezone)->day] = '<a href="javascript:;" class="view-attendance" data-attendance-id="' . $attendance->id . '"><i class="fa fa-check text-success"></i></a>';
            }

            $image = '<img src="' . $employee->image_url . '" alt="user" class="img-circle" width="30" height="30"> ';
            $final[$employee->id . '#' . $employee->name][] = '<a class="userData" id="userID' . $employee->id . '" data-employee-id="' . $employee->id . '"  href="' . route('admin.employees.show', $employee->id) . '">' . $image . ' ' . ucwords($employee->name) . '</a>';

            foreach ($this->holidays as $holiday) {
                if ($final[$employee->id . '#' . $employee->name][$holiday->date->day] == 'Absent') {
                    $final[$employee->id . '#' . $employee->name][$holiday->date->day] = 'Holiday';
                }
            }
        }


        $this->employeeAttendence = $final;

        $view = view('admin.attendance.summary_data', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'data' => $view]);
    }
    public function AttendanceByPlayer()
    {
        abort_if(!$this->user->cans('view_players'),403);

        $openDays = json_decode($this->attendanceSettings->office_open_days);
        $this->startDate = Carbon::today()->timezone($this->global->timezone)->startOfMonth();
        $this->endDate = Carbon::now()->timezone($this->global->timezone);
        $this->employees = memberDetails::where('player' , 1)->get();
        $this->userId = User::first()->id;

        $this->totalWorkingDays = $this->startDate->diffInDaysFiltered(function (Carbon $date) use ($openDays) {
            foreach ($openDays as $day) {
                if ($date->dayOfWeek == $day) {
                    return $date;
                }
            }
        }, $this->endDate);
        $this->daysPresent = Attendance::countDaysPresentByUser($this->startDate, $this->endDate, $this->userId);
        $this->daysLate = Attendance::countDaysLateByUser($this->startDate, $this->endDate, $this->userId);
        $this->halfDays = Attendance::countHalfDaysByUser($this->startDate, $this->endDate, $this->userId);
        $this->holidays = Count(Holiday::getHolidayByDates($this->startDate->format('Y-m-d'), $this->endDate->format('Y-m-d')));

        return view('admin.players.att_by_player', $this->data);
    }
    public function redirectToEdit($member_id){
        if (memberDetails::where('member_id',$member_id)->first()) {
            if (memberDetails::where('member_id',$member_id)->first()->player != 1) {
                // return $role = $this->sendRequest($member_id);
                return Reply::redirect(route('admin.players.storeFromMember', $member_id));
            }else{
                return Reply::error(__('messages.member_is_player'));
            }
        }else{

            return Reply::error(__('messages.user_not_exist'));
        }
    }
   



    public function data(Request $request, $userId = null)
    {
        abort_if(!$this->Player->cans('player_id'), 403);

        $player = Player::select(
            'players.id', 
            'players.player_id',
            'players.union_id', 
            'players.name', 
            'players.national_id', 
            'players.atu_sport', 
            'players.atu_acadmy', 
            'players.team_id',
            'players.status_id',
            'players.gender',
            'players.date_of_birth',
            'players.age',
            'players.city',
            'players.country_id',
            'players.state',
            'players.champions_award',
            'players.address',
            'players.mobile',
            'players.guardian_mobile',
            'players.note',
            'players.created_at',
            'players.updated_at',

        );

       
        $players = $player->get();

        return DataTables::of($players)
            ->addColumn('player_id', function ($row) {
                return ucwords($row->player_id);
            })
            ->addColumn('union_id', function ($row) {
                $type = $row->union_id;
                return $type;
            })
            ->addColumn('name', function ($row) {
                $type = $row->name;
                return $type;
            })
            
       

            ->addIndexColumn()
            ->rawColumns(['player_id'])
            ->make(true);
    }

    
}