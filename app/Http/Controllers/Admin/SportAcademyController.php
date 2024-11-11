<?php

namespace App\Http\Controllers\Admin;

use App\ClientSubCategory;
use App\Country;
use App\DataTables\Admin\SportAcademyDataTable;
use App\DataTables\Admin\TeamPlayersDataTable;
use App\DataTables\Admin\SportSessionDataTable;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Club\StoreSportAcademyRequest;
use App\memberCategory;
use App\Project;
use App\SportAcademy;
use App\User;
use Illuminate\Http\Request;
use function abort_if;

class SportAcademyController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.sport_academies';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('sportAcademies', $this->user->modules),403);
            return $next($request);
        });
    }

    public function index(SportAcademyDataTable $dataTable){
        abort_if(!$this->user->cans('view_sportAcademies'),403);
        $this->sports=SportAcademy::all();
        $this->totalSports = count($this->sports);
        return $dataTable->render('admin.sport-academy.index', $this->data);
    }
    public function create()
    {
        abort_if(!$this->user->cans('add_sportAcademies'),403);

        $this->sports = SportAcademy::all();
        return view('admin.sport-academy.create_sport', $this->data);
    }
    public function edit($id)
    {
        abort_if(!$this->user->cans('edit_sportAcademies'),403);

        $this->sports = SportAcademy::all();
        $this->sport = SportAcademy::find($id);
        return view('admin.sport-academy.edit', $this->data);
    }
    public function store(StoreSportAcademyRequest $request)
    {
        abort_if(!$this->user->cans('add_sportAcademies'),403);

        $sport = new SportAcademy();
        $sport->name = $request->name;
        $sport->description = $request->description;
        $sport->code = $request->code;
        if ($request->hasFile('image')) {
            $sport->image = Files::upload($request->image, 'avatar', 300);
        }
        $sport->save();
        $sportsData = SportAcademy::all();
        //return Reply::successWithData(__('messages.sportAdded'),['data' => $sportsData]);
        return Reply::redirect(route('admin.sportAcademy.index'));
    }
    public function update(StoreSportAcademyRequest $request , $id)
    {
        abort_if(!$this->user->cans('edit_sportAcademies'),403);

        $sport =SportAcademy::find($id);
        $sport->name = $request->name;
        $sport->code = $request->code;
        $sport->description = $request->description;
        if ($request->hasFile('image')) {
            $sport->image = Files::upload($request->image, 'avatar', 300);
        }
        $sport->save();
        $sportsData = SportAcademy::all();
        return Reply::successWithData(__('messages.sportAdded'),['data' => $sportsData]);
    }

    public function destroy($id)
    {
        abort_if(!$this->user->cans('delete_sportAcademies'),403);

        SportAcademy::destroy($id);
        $sports = SportAcademy::all();
        return Reply::successWithData(__('messages.sportDeleted'),['data' => $sports]);
    }
}
