<?php

namespace App\Http\Controllers\Admin;

use App\Cases;
use App\DataTables\Admin\CasesDataTable;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Penalty\StoreCaseRequest;
use App\Http\Requests\Admin\Penalty\StorePenaltyRequest;

class CasesController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.cases';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('legalAffairs', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(CasesDataTable $dataTable){
        abort_if(!$this->user->cans('view_legalAffairs'),403);

        $this->cases=Cases::all();
        $this->totalCases=count($this->cases);
        return $dataTable->render('admin.cases.index', $this->data);
    }
    public function show($id){
        abort_if(!$this->user->cans('view_legalAffairs'),403);

        $this->case=Cases::find($id);
        return view('admin.cases.show', $this->data);
    }
    public function create(){
        abort_if(!$this->user->cans('add_legalAffairs'),403);

        return view('admin.cases.create', $this->data);
    }
    public function store(StoreCaseRequest $request){
        abort_if(!$this->user->cans('add_legalAffairs'),403);

        $case=new Cases();
            $case->case_name=$request->case_name;
        $case->case_id=$request->case_id;
        $case->details=$request->details;
                $lawyers=$request->input('lawyers');
                $opponents=$request->input('opponents');
                $case->lawyers=json_encode($lawyers);
                $case->opponents=json_encode($opponents);
        $case->save();
        return Reply::redirect(route('admin.cases.index'));

    }
    public function edit($id){
        abort_if(!$this->user->cans('edit_legalAffairs'),403);

        $this->case=Cases::find($id);

        return view('admin.cases.edit', $this->data);
    }
    public function update(StoreCaseRequest $request , $id){
        abort_if(!$this->user->cans('edit_legalAffairs'),403);

        $case=Cases::find($id);
        $case->case_name=$request->case_name;
        $case->case_id=$request->case_id;
        $case->details=$request->details;
        $lawyers=$request->input('lawyers');
        $opponents=$request->input('opponents');
        $case->lawyers=json_encode($lawyers);
        $case->opponents=json_encode($opponents);
        $case->save();
        return Reply::redirect(route('admin.cases.index'));
    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_legalAffairs'),403);

        Cases::destroy($id);
        return Reply::success('messages.Success');
    }
}
