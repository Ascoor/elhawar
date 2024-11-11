<?php

namespace App\Http\Controllers\Admin\Stocks;

use App\DataTables\Admin\StocksDataTable;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Notifications\ItemDecreased;
use App\User;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\Inventory;
use App\ProductInventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class StockController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Stocks';
        $this->pageIcon = 'icon-basket';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('inventories', $this->user->modules),403);
            return $next($request);
        });
        $this->middleware('permission:add_inventories')->only('store');
        $this->middleware('permission:edit_inventories')->only('edit','update','moveProducts');
        $this->middleware('permission:view_inventories')->only('show','index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StocksDataTable $dataTable)
    {
        $this->totalInventories = Inventory::count();

        return $dataTable->render('admin.stocks.index', $this->data);
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
            'description'=> 'required',
            'location'=> 'required',
        ]);
        $inventory = new Inventory();

        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->location = $request->location;

        $inventory->save();
        return redirect()->back();

    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $inventory = Inventory::find($id);
        
        return view('admin.stocks.edit', $this->data,compact('inventory'));
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
            'location'=> 'required',
        ]);
        $inventory =  Inventory::find($id);

     
        
        $inventory->name = $request->name;
        $inventory->description = $request->description;
        $inventory->location = $request->location;
        
        $inventory->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = $this->getProducts()->get();
        
        $inventory = Inventory::find($id);
        $products = $this->getSingleProduct($id)->get();

        $other_inventories = DB::table('inventories')->where('id', '!=' ,$id)->get();
        return view('admin.stocks.show', $this->data,compact('inventory','products','other_inventories'));
    } 

    public function moveProducts(Request $request,$id){
        // return $request;
        $this->validate($request,[
            'product' => 'required',
            'inventory'=> 'required',
            'quantity'=> 'required',
        ]);
        
        
        DB::table('product_inventories')
        ->where('product','=', $request->product)
        ->where('inventory','=',$id)
        ->decrement('item_in_stock' , $request->quantity);
        $transfare = ProductInventory::firstOrNew(array('product' => $request->product,'inventory'=>$request->inventory));
        $transfare->item_in_stock = $transfare->item_in_stock ?  $transfare->item_in_stock+$request->quantity :$request->quantity;
        $transfare->save();
    
        
      return redirect()->back();
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    private function getProducts(): \Illuminate\Database\Query\Builder
    {
        return DB::table('product_inventories')
            ->join('products', 'products.id', '=', 'product_inventories.product')
            ->join('inventories', 'product_inventories.inventory', '=', 'inventories.id')
            ->join('product_category', 'products.category_id', 'product_category.id')
            ->select('products.*', 'product_inventories.price', 'inventories.name as inventory_name', 'inventories.id as inventory_id', 'product_category.name as category_name')
            ;
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Query\Builder
     */
    private function getSingleProduct(int $id): \Illuminate\Database\Query\Builder
    {
        return
           $this->getProducts()->where('product_inventories.inventory', $id);

    }

    public function destroy($id)
    {
        Inventory::destroy($id);
        return Reply::redirect(route('admin.stocks.index'), __('messages.contactDeleted'));
    }
}

