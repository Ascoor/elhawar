<?php

namespace App\Http\Controllers\Admin\Stocks;

use App\DataTables\Admin\CategoryDataTable;
use App\DataTables\Admin\ItemsDataTable;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Inventory;
use App\Product;
use App\ProductCategory;
use App\ProductInventory;
use App\ProductStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Products';
        $this->pageIcon = 'icon-basket';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('inventories', $this->user->modules),403);
            return $next($request);
        });
        $this->middleware('permission:add_inventories')->only('store');
        $this->middleware('permission:edit_inventories')->only('edit','update');
        $this->middleware('permission:view_inventories')->only('show','index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemsDataTable $dataTable)
    { 



        $categories =  $this->getCategories();
        
        $products = $this->getProducts()->get();

        $inventories = Inventory::all();
        $this->totalProducts = Product::count();

        return $dataTable->render('admin.items.index', $this->data,compact('products','categories','inventories'));
    }
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $name=$request->name;
       $category=$request->category;
       $price=$request->price;
        if(!$name)return redirect(route('admin.items.index'))->with(['error' => 'لم يتم تحديد اسم المنتج']);
        if(!$category)return redirect(route('admin.items.index'))->with(['error' => 'لم يتم تحديد  الصنف']);
        if(!$price)return redirect(route('admin.items.index'))->with(['error' => 'لم يتم تحديد  السعر']);
        $inventories = Inventory::all();
        // return $inventories;
        $found_inventory=0;
        
        foreach ($inventories as $inventory) {
              if($request->{$inventory->id}){
                $found_inventory =1;
              }
        }
        
        if(!$found_inventory) return redirect(route('admin.items.index'))->with(['error' => 'لم يتم تحديد بيانات المخزن']);
        $product = new Product();
        $new_product = $product->create([
            'name' => $request->name,
            'category_id' => $request->category,
            'expiration_date'=> $request->expiration_date ?? null,
            'allow_purchase'=> $request->purchase_allow ?? 0
        ]);
        
        $product_inventory = new ProductInventory();
        foreach ($inventories as $inventory) {
            if($request->{$inventory->id}){
                $product_inventory->create([
                    'product' => $new_product->id,
                    'inventory' => $inventory->id,
                    'price' => $price,
                    'item_in_stock' => $request->{'s'.$inventory->id} ?? 1
                ]);
            }
      }
      return redirect(route('admin.items.index'))->with(['successful_message' => __('app.addedSuccessfully')]);
      
    }
    public function edit($id)
    {
        $categories =  $this->getCategories();
        $product = $this->getProducts()->where('product_inventories.id',$id)->get()->first();
        $product_inventory = ProductInventory::find($id);

        $inventories = Inventory::all();

        return view('admin.items.edit', $this->data,compact('product_inventory','inventories','categories','product'));
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
            'category'=> 'required'
        ]);
        $product_inventory = ProductInventory::find($id);
        $product_inventory->price = $request->price;
        $product_inventory->item_in_stock = $request->item_in_stock;
        $product = Product::find($request->product);
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->allow_purchase = $request->purchase_allow ?? 0;
        $product_inventory->save();
        $product->save();
        return redirect()->back();
    }
    
    public function mapCategories($categories){
    //   dd($categories);
      $category_map = array('sub' => '');
      $category_map = (object)$category_map;
      $array = array();
      foreach($categories as $category){
        $result =  DB::table('product_sub_category')->where('category_id', $category->id)->get();
       array_push($array,$result);
      }
      return $array;
    }
    private function getProducts(){
        return DB::table('product_inventories')
        ->join('products','products.id','=','product_inventories.product')
        ->join('inventories','product_inventories.inventory','=','inventories.id')
        ->join('product_category','products.category_id','product_category.id')
        ->select('product_inventories.*','inventories.id as inventory_id','inventories.name as inventory_name','products.name','products.allow_purchase','product_category.id as category_id','product_category.name as category_name')
        ;
    }
    private function getCategories(){
        return DB::table('product_sub_category')
        ->join('product_category', 'product_category.id', '=', 'product_sub_category.category_id')
        ->select('product_category.id','product_category.name','product_category.description','product_sub_category.sub_category')
        ->where('product_sub_category.sub_category',null)
        ->get();
    }
    
}
