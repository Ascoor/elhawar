<?php

namespace App\Http\Controllers\Admin;
use App\ClientSubCategory;
use App\Country;
use App\DataTables\Admin\SportTowDataTable;
use App\DataTables\Admin\TeamPlayersDataTable;
use App\DataTables\Admin\SportSessionDataTable;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Club\StoreSportTowRequest;
use App\memberCategory;
use App\Project;
use App\SportTow;
use App\User;
use Illuminate\Http\Request;
use function abort_if;

class SportTowController extends AdminBaseController
{
   public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sport_academies';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('sportTows', $this->user->modules),403);
            return $next($request);
        });
    }
  
    public function index(SportTowDataTable $dataTable){
        abort_if(!$this->user->cans('view_sport'),403);
        $this->sports=SportTow::all();
        $this->totalSports = count($this->sports);
        return $dataTable->render('admin.sport_tow.index', $this->data);
    }
    public function create()
    {
        abort_if(!$this->user->cans('add_sport'),403);

        $this->sports = SportTow::all();
        return view('admin.sport_tow.create_sport', $this->data);
    }
    public function edit($id)
    {
        abort_if(!$this->user->cans('edit_sport'),403);

        $this->sports = SportTow::all();
        $this->sport = SportTow::find($id);
        return view('admin.sport_tow.edit', $this->data);
    }
    public function store(StoreSportTowRequest $request)
    {
        abort_if(!$this->user->cans('add_sport'),403);

        $sport = new SportTow();
        $sport->name = $request->name;
        $sport->description = $request->description;
        $sport->code = $request->code;
        if ($request->hasFile('image')) {
            $sport->image = Files::upload($request->image, 'avatar', 300);
        }
        $sport->save();
        $sportsData = SportTow::all();
        return Reply::successWithData(__('messages.sportAdded'),['data' => $sportsData]);
    }
    public function update(StoreSportTowRequest $request , $id)
    {
        abort_if(!$this->user->cans('edit_sport'),403);

        $sport =SportTow::find($id);
        $sport->name = $request->name;
        $sport->code = $request->code;
        $sport->description = $request->description;
        if ($request->hasFile('image')) {
            $sport->image = Files::upload($request->image, 'avatar', 300);
        }
        $sport->save();
        $sportsData = SportTow::all();
        return Reply::successWithData(__('messages.sport'),['data' => $sportsData]);
    }

    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_sport'),403);

        SportTow::destroy($id);
        $sports = SportTow::all();
        return Reply::successWithData(__('messages.sportDeleted'),['data' => $sports]);
    }
}
