<?php

namespace App\Http\Controllers\Admin;

use App\Currency;
use App\DataTables\Admin\GeneralAssemblyDataTable;
use App\GeneralAssembly;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GeneralAssemblyController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.general_assembly';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('members', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(GeneralAssemblyDataTable $dataTable){
        abort_if(!$this->user->cans('view_members'),403);
        $this->assemblies=GeneralAssembly::all();
        $this->totalAssemblies = count($this->assemblies);
        return $dataTable->render('admin.general-assembly.index', $this->data);
    }

    public function create(){
        abort_if(!$this->user->cans('edit_members'),403);
        $this->currencies=Currency::all();
        return view('admin.general-assembly.create', $this->data );
    }
    public function store(Request $request){
        abort_if(!$this->user->cans('edit_members'),403);

        $assembly=new GeneralAssembly();
        $assembly->name=$request->name;
        $assembly->start_date=Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d');
        $assembly->delay_fine=$request->delay_fine;
        $assembly->currency=$request->currency;
        $assembly->save();
        return Reply::redirect(route('admin.assembly.index'));
    }
    public function edit($id){
        abort_if(!$this->user->cans('edit_members'),403);
        $this->assembly=GeneralAssembly::find($id);
        $this->currencies=Currency::all();
        return view('admin.general-assembly.edit', $this->data );
    }
    public function update(Request $request , $id){
        abort_if(!$this->user->cans('edit_members'),403);
        $assembly=GeneralAssembly::find($id);
        $assembly->name=$request->name;
        $assembly->start_date=Carbon::createFromFormat($this->global->date_format, $request->start_date)->format('Y-m-d');
        $assembly->delay_fine=$request->delay_fine;
        $assembly->currency=$request->currency;
        $assembly->save();
        return Reply::redirect(route('admin.assembly.index'));
    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_members'),403);

        GeneralAssembly::destroy($id);
        return Reply::success(__('messages.assemblyDeleted'));
    }
}
