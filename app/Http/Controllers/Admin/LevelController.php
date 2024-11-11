<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Level;
use Illuminate\Http\Request;

class LevelController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.levels';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('clients', $this->user->modules),403);
            return $next($request);
        });
    }
    public function create()
    {
        $this->levels = Level::all();
        return view('admin.sport-academy.create_level', $this->data);
    }
    public function store(Request $request)
    {
        $level = new Level();
        $level->name = $request->level_name;
        $level->save();
        $levelsData = Level::all();
        return Reply::successWithData(__('messages.levelAdded'),['data' => $levelsData]);
    }
    public function destroy($id)
    {
        Level::destroy($id);
        $levels = Level::all();
        return Reply::successWithData(__('messages.levelDeleted'),['data' => $levels]);
    }
}
