<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SportsDataTable;
use App\DataTables\Admin\TeamPlayersDataTable;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Club\StoreSportRequest;
use App\sports;
use Illuminate\Http\Request;

class SportsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sports';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('sportTeams', $this->user->modules),403);
            return $next($request);
        });
    }

    public function index(SportsDataTable $dataTable){
        abort_if(!$this->user->cans('view_sportTeams'),403);

        $this->sports=Sports::all();
        $this->totalSports = count($this->sports);
        return $dataTable->render('admin.sports.index', $this->data);
    }
    public function create()
    {

        $this->sports = sports::all();
        return view('admin.sports.create', $this->data);
    }

    // public function create_2()
    // {
    //     abort_if(!$this->user->cans('add_sportTeams'),403);

    //     $this->sports = sports::all();
    //     return view('admin.sports.create_2', $this->data);
    // }

    public function edit($id)
    {
        abort_if(!$this->user->cans('edit_sportTeams'),403);

        $this->sports = sports::all();
        $this->sport = sports::find($id);
        return view('admin.sports.edit', $this->data);
    }

 
    
    public function store(StoreSportRequest $request)
    {
        abort_if(!$this->user->cans('add_sportTeams'),403);

        $sport = new sports();
        $sport->name = $request->name;
        $sport->code = $request->code;
        $sport->kind = $request->kind;
        if ($request->hasFile('image')) {
            $sport->image = Files::upload($request->image, 'avatar', 300);
        }
        $sport->save();
        $sportsData = sports::all();
        // return Reply::successWithData(__('messages.sportAdded'));
        return Reply::redirect(route('admin.sports.index'));
    }

    
    public function update(StoreSportRequest $request , $id)
    {
        abort_if(!$this->user->cans('edit_sportTeams'),403);

        $sport =sports::find($id);
        $sport->name = $request->name;
        $sport->code = $request->code;
        $sport->kind = $request->kind;
        
        if ($request->hasFile('image')) {
            $sport->image = Files::upload($request->image, 'avatar', 300);
        }
        $sport->save();
        $sportsData = sports::all();
        // return Reply::successWithData(__('messages.sportUpdated'),['data' => $sportsData]);
        return Reply::redirect(route('admin.sports.index'));

    }
    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_sportTeams'),403);

        sports::destroy($id);
        $sports = sports::all();
        return Reply::successWithData(__('messages.sportDeleted'),['data' => $sports]);
    }

}
