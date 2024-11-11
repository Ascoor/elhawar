<?php

namespace App\Http\Controllers\Club;

use App\Notice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClubNoticeController extends ClubBaseController
{
    public function __construct() {
        parent::__construct();
        $this->pageTitle = 'app.menu.noticeBoard';
        $this->pageIcon = 'ti-layout-media-overlay';
    }

    public function index() {
        $this->notices = Notice::orderBy('id', 'desc')->where('to', 'member')->get();
        return view('club.notices.index', $this->data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->notice = Notice::find($id);

        $readUser = $this->notice->member->filter(function ($value, $key) {
            return $value->user_id == $this->user->id && $value->notice_id == $this->notice->id;
        })->first();

        if ($readUser) {
            $readUser->read = 1;
            $readUser->save();
        }

        return view('club.notices.show', $this->data);
    }

    public function data(Request $request)
    {
        $notice = Notice::select('id','heading', 'created_at')->where('to', 'member');
        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
            $notice = $notice->where(DB::raw('DATE(notices.`created_at`)'), '>=', $startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
            $notice = $notice->where(DB::raw('DATE(notices.`created_at`)'), '<=', $endDate);
        }

        $notice = $notice->get();

        return DataTables::of($notice)
            ->addColumn('action', function ($row) {
                $action = '';

                $action .= ' <a href="javascript:showNoticeModal(' . $row->id . ')" class="btn btn-success btn-circle"
                  data-toggle="tooltip" data-placement="right" data-original-title="View Details"><i class="fa fa-search" aria-hidden="true"></i></a>';

                return $action;
            })
            ->addColumn('heading', function($row){
                return '<a href="javascript:showNoticeModal(' . $row->id . ')"  data-notice-id="' . $row->id . '"  class="noticeShow">' .ucfirst($row->heading) . '</a>';
            })
            ->editColumn(
                'created_at',
                function ($row) {
                    return Carbon::parse($row->created_at)->format($this->global->date_format);
                }
            )
            ->rawColumns(['heading','action'])
            ->make(true);
    }
}