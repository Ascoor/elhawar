<?php

namespace App\Http\Controllers\Admin\Stocks;

use App\DataTables\Admin\TransactionsDataTable;
use App\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Http\Request;

use App\Inventory;
use App\Product;
use App\PurchaseTransaction;
use Illuminate\Support\Facades\DB;
use net\authorize\api\contract\v1\TransactionDetailsType;

class TransactionsController extends AdminBaseController
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
        $this->middleware('permission:view_inventories')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionsDataTable $dataTable)
    {
        $this->products = DB::table('stock_transactions')
            ->Join('product_inventories', 'stock_transactions.product', '=', 'product_inventories.id')
            ->Join('products','products.id','=','product_inventories.product')
            ->select('stock_transactions.product','products.name')
            ->distinct('stock_transactions.product')
            ->get();
        $this->inventories = Inventory::all();
        return $dataTable->render('admin.stocks.transactions', $this->data);
        
        
    }
}