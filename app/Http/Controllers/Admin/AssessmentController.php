<?php

namespace App\Http\Controllers\Admin;

use App\Assessment;
use App\DataTables\Admin\AssessmentsDataTable;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\memberDetails;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AssessmentController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.assessments';
        $this->pageIcon = 'icon-invoice';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('players', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(AssessmentsDataTable $dataTable){
        abort_if(!$this->user->cans('edit_players'),403);
        $this->assessments=Assessment::all();
        $this->totalAssess = count($this->assessments);
        return $dataTable->render('admin.assessments.index', $this->data);
    }
    public function show($id){
        abort_if(!$this->user->cans('view_players'),403);

        $this->assessment=Assessment::find($id);
        $this->player=memberDetails::where('user_id',$this->assessment->player_id)->first();
        return view('admin.assessments.show', $this->data);
    }
public function create(){
    abort_if(!$this->user->cans('edit_players'),403);

    return view('admin.assessments.create', $this->data );
}
public function store(Request $request){
    abort_if(!$this->user->cans('edit_players'),403);

    $player=memberDetails::where('member_id',$request->member_id)->first();

    if ($player) {
        if ($player->player == 1) {

            $user=User::find($player->user_id);
            $assessment=new Assessment();
            $assessment->player_id=$user->id;
            $assessment->injuries_effect=$request->injuries_effect;
            $assessment->physical_assessment=$request->physical_assess;
            $assessment->skills_assessment=$request->skills_assess;
            $assessment->injuries=$request->injuries;
            $assessment->name=$request->name;
            $assessment->at_date=Carbon::createFromFormat($this->global->date_format, $request->at_date)->format('Y-m-d');
            $assessment->save();
            return Reply::redirect(route('admin.assessments.index'));
        }else{
            return Reply::error(__('messages.member_is_not_player'));
        }
    }else{

        return Reply::error(__('messages.user_not_exist'));
    }

}
public function edit($id){
    abort_if(!$this->user->cans('edit_players'),403);

    $this->assessment=Assessment::find($id);
        $this->player=memberDetails::where('user_id',$this->assessment->player_id)->first();
    return view('admin.assessments.edit', $this->data );
}
public function update(Request $request , $id){
    abort_if(!$this->user->cans('edit_players'),403);

    $assessment=Assessment::find($id);
    $assessment->injuries_effect=$request->injuries_effect;
    $assessment->physical_assessment=$request->physical_assess;
    $assessment->skills_assessment=$request->skills_assess;
    $assessment->injuries=$request->injuries;
    $assessment->name=$request->name;
    $assessment->at_date=Carbon::createFromFormat($this->global->date_format, $request->at_date)->format('Y-m-d');
    $assessment->save();
    return Reply::redirect(route('admin.assessments.index'));
}

public function destroy($id){
    abort_if(!$this->user->cans('delete_players'),403);
    Assessment::destroy($id);
    return Reply::success(__('messages.assessmentDeleted'));
}

}
