<?php

namespace App\Http\Controllers\Admin\Purchases;

use App\DataTables\Admin\PurchaseTransactionsDataTable;
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
        $this->pageTitle = 'Purchases';
        $this->pageIcon = 'icon-basket';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchaseTransactionsDataTable $dataTable)
    {
        $products = DB::table('purchase_transactions')
            ->Join('product_inventories', 'purchase_transactions.product', '=', 'product_inventories.id')
            ->Join('products','products.id','=','product_inventories.product')
            ->select('purchase_transactions.product','products.name')
            ->distinct('purchase_transactions.product')
            ->get();
            // return $products;
        return $dataTable->render('admin.purchases.transactions', $this->data,compact('products'));
        
        
    }
    

    
    
   
}