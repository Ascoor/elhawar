<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\memberCategory;
use App\memberRelations;
use App\memberStatus;
use Illuminate\Http\Request;
use App\ClientCategory;
use App\ClientSubCategory;
use App\Helper\Reply;
use App\Http\Requests\Admin\Client\StoreClientCategory;
use App\Http\Requests\Admin\Client\StoreClientSubcategory;

class MemberStatusController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->statuses = memberStatus::all();
        return view('admin.members.create_status', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = new memberStatus();
        $status->status_name = $request->status_name;
        $status->save();
        $statusData = memberStatus::all();
        return Reply::successWithData(__('messages.statusAdded'),['data' => $statusData]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state=memberStatus::find($id);
        $status = memberStatus::all();
        if ($state->id >4) {
            memberStatus::destroy($id);
            return Reply::successWithData(__('messages.statusDeleted'), ['data' => $status]);
        }else{
            return Reply::error(__('messages.status_cant_be_deleted'), ['data' => $categories]);
        }
    }
}
