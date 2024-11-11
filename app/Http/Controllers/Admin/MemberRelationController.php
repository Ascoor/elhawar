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

class MemberRelationController extends AdminBaseController
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
        $this->relations = memberRelations::all();
        return view('admin.members.create_relation', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $relation = new memberRelations();
        $relation->relation_name = $request->relation_name;
        $relation->save();
        $relationData = memberRelations::all();
        return Reply::successWithData(__('messages.relationAdded'),['data' => $relationData]);
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
        $relation=memberRelations::find($id);
        $relations = memberRelations::all();

        if ($relation->id > 5) {
            memberRelations::destroy($id);
            return Reply::successWithData(__('messages.relationDeleted'), ['data' => $relations]);
        }else{
            return Reply::error(__('messages.relationCantBeDeleted'), ['data' => $relations]);
        }
    }


}
