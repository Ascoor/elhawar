<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PlayerGroup;
use Froiden\Envato\Helpers\Reply;
use Illuminate\Http\Request;

class PlayerGroupController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.groups';
        $this->pageIcon = 'icon-people';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('clients', $this->user->modules),403);
            return $next($request);
        });
    }
    public function create()
    {
        $this->groups = PlayerGroup::all();
        return view('admin.sport-academy.create_group', $this->data);
    }
    public function store(Request $request)
    {
        $group = new PlayerGroup();
        $group->name = $request->name;
        $group->save();
        $groupsData = PlayerGroup::all();
        return Reply::successWithData(__('messages.groupAdded'),['data' => $groupsData]);
    }
    public function destroy($id)
    {
        PlayerGroup::destroy($id);
        $groups = PlayerGroup::all();
        return Reply::successWithData(__('messages.groupDeleted'),['data' => $groups]);
    }
}
