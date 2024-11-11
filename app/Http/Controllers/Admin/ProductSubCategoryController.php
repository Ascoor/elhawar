<?php

namespace App\Http\Controllers\Admin;

use App\EngineeringProductCategory;
use App\EngineeringProductSubCategory;
use App\Helper\Reply;
use App\Http\Requests\Product\StoreProductSubCategory;
use App\Http\Requests\Project\StoreProjectCategory;
use App\ProductCategory;
use App\ProductSubCategory;
use Illuminate\Http\Request;

class ProductSubCategoryController extends AdminBaseController
{

    public function __construct() {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->categoryID = $request->catID;
        $this->subCategories = EngineeringProductSubCategory::all();
        $this->categories = EngineeringProductCategory::all();
        return view('admin.products.create-sub-category', $this->data);
    }


    /**
     * @param StoreProductSubCategory $request
     * @return array
     */
    public function store(StoreProductSubCategory $request)
    {
        $category = new EngineeringProductSubCategory();
        $category->category_id = $request->category;
        $category->category_name = $request->sub_category_name;
        $category->save();
        $subCategoryData = EngineeringProductSubCategory::with('category')->get();
        $categoryData     = EngineeringProductCategory::all();
        return Reply::successWithData(__('messages.categoryAdded'),['data' => $subCategoryData, 'catData' => $categoryData ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        EngineeringProductSubCategory::destroy($id);
        $categoryData = EngineeringProductSubCategory::all();
        return Reply::successWithData(__('messages.categoryDeleted'),['data' => $categoryData]);
    }
}
