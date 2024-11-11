<?php

namespace App\Http\Controllers\Admin\Stocks;


use App\DataTables\Admin\CategoryDataTable;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Http\Controllers\Admin\AdminBaseController;
use App\ProductCategory as Category;
use App\ProductCategory;
use App\ProductSubCategory as SubCategory;
use Illuminate\Support\Facades\DB;

class CategoryController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Categories';
        $this->pageIcon = 'icon-basket';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('inventories', $this->user->modules),403);
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryDataTable $dataTable)
    {
        $this->totalCategories = ProductCategory::count();
        return $dataTable->render('admin.categories.index', $this->data);

        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->categories = ProductCategory::all();
        return view('admin.items.create-item', $this->data);
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'description' => 'required',
        ]);
        $category_id = DB::table('product_category')->insertGetId(
            array('name' => $request->name, 'description' => $request->description)
        );

        DB::table('product_sub_category')->insertGetId(
            array('category_id' =>$category_id, 'sub_category' => null)
        );
        $categoryData = ProductCategory::all();
        return Reply::successWithData(__('messages.categoryAdded'),['data' => $categoryData]);

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $sub_categories =  DB::table('product_sub_category')->join('product_category', 'product_category.id', '=', 'product_sub_category.sub_category')
        ->select('product_category.id','product_category.name','product_category.description')->where('product_sub_category.category_id',$id)->get();
        
        return view('admin.categories.edit', $this->data,compact('category','sub_categories'));
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
        $this->validate($request,[
            'name' => 'required',
            'description'=> 'required',
        ]);
        $category = new Category();
        if($request->sub_category_name){
            $category_id = DB::table('product_category')->insertGetId(
                array('name' => $request->sub_category_name, 'description' => $request->sub_category_description)
            );
            
            DB::table('product_sub_category')->insertGetId(
                array('category_id' => $category_id, 'sub_category' => null)
            );

            $sub_category = new SubCategory();   

           
            $sub_category_count = DB::table('product_sub_category')->where('category_id', $id)->where('sub_category', null)->get();

         if($sub_category_count->count() === 1)
           {  
                DB::table('product_sub_category')
                ->where('category_id', $id)
                ->update(array('sub_category' => $category_id));
           }else{   
            DB::table('product_sub_category')->insertGetId(
                array('category_id' => $id, 'sub_category' => $category_id)
            );
                // $sub_category->category_id = $id;
                // $sub_category->sub_category = $category_id;
                // $sub_category->save();
           }  
        }
        DB::table('product_category')
                ->where('id', $id)
                ->update(array('name'=>$request->name,'description' => $request->description));

        return Reply::success(__('messages.updatedSuccessfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $category = Category::find($id);
        $sub_categories =  DB::table('product_sub_category')->join('product_category', 'product_category.id', '=', 'product_sub_category.sub_category')
        ->select('product_category.id','product_category.name','product_category.description')->where('product_sub_category.category_id',$id)->get();
        

        $products = DB::table('product_inventories')
        ->join('products','products.id','=','product_inventories.product')
        ->join('inventories','product_inventories.inventory','=','inventories.id')

        ->join('product_category','products.category_id','product_category.id')
        ->select('products.*','product_inventories.price','inventories.name as inventory_name','inventories.id as inventory_id','product_category.name as category_name')
        ->where('product_category.id',$id)
        ->get();
        
        return view('admin.categories.show', $this->data,compact('category','products','sub_categories'));
    } 

    
}
