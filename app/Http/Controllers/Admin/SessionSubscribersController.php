<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SubscribersDataTable;
use App\Helper\Reply;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;

class SessionSubscribersController extends AdminBaseController
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
    public function index(SubscribersDataTable $dataTable){
        abort_if(!$this->user->cans('view_sportAcademies'),403);

        $this->sports=SportAcademy::all();
        $this->sessions=SportSession::all();
//        $this->totalSports = count($this->sports);
        return $dataTable->render('admin.sport-academy.subscribers_index', $this->data);
    }
    public function destroy($id){
        abort_if(!$this->user->cans('delete_sportAcademies'),403);

        $session=SessionMember::find($id);
        $allSessions=SportSession::where('session_id' ,$session->session_id )->get();
        if ($session->status == 'subscription') {
            foreach ($allSessions as $relatedSession) {
                $relatedSession->available++;
                $relatedSession->save();

            }
        }else {
            foreach ($allSessions as $relatedSession) {
                $relatedSession->waiting--;
                $relatedSession->save();
            }
        }
        $session->delete();
        return Reply::success(__('messages.subscriptionDeleted'));

    }

}