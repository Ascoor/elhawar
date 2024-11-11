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

class MemberCategoryController extends AdminBaseController
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
        $this->categories = memberCategory::all();
        return view('admin.members.create_category', $this->data);
    }
    public function addRelation()
    {
        $this->relations = memberRelations::all();
        return view('admin.members.create_relation', $this->data);
    }
    public function addStatus()
    {
        $this->status = memberStatus::all();
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
        $category = new memberCategory();
        $category->category_name = $request->category_name;
        $category->save();
        $categoryData = memberCategory::all();
        return Reply::successWithData(__('messages.categoryAdded'),['data' => $categoryData]);
    }
    public function storeRelation(Request $request)
    {
        $relation = new memberRelations();
        $relation->relation_name = $request->relation_name;
        $relation->save();
        $relationData = memberRelations::all();
        return Reply::successWithData(__('messages.relationAdded'),['data' => $relationData]);
    }
    public function storeStatus(Request $request)
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
        $category=memberCategory::find($id);
        $categories = memberCategory::all();

        if ($category->id > 3) {
            memberCategory::destroy($id);
            return Reply::successWithData(__('messages.categoryDeleted'), ['data' => $categories]);
        }else{
            return Reply::error(__('messages.category_cant_be_deleted'), ['data' => $categories]);
        }
    }
    public function destroyRelation($id)
    {
        memberRelations::destroy($id);
        $relations = memberRelations::all();
        return Reply::successWithData(__('messages.relationDeleted'),['data' => $relations]);
    }
    public function destroyStatus($id)
    {
        memberStatus::destroy($id);
        $status = memberStatus::all();
        return Reply::successWithData(__('messages.statusDeleted'),['data' => $status]);
    }
}
