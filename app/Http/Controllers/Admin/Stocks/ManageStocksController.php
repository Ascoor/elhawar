<?php

namespace App\Http\Controllers\Admin\Stocks;
use App\DataTables\Admin\RequestsDataTable;
use App\Http\Controllers\Admin\AdminBaseController;
use App\ClientPayment;
use App\CreditNotes;
use App\Currency;
use App\DataTables\Admin\InvoicesDataTable;
use App\Estimate;
use App\Events\PaymentReminderEvent;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Admin\Client\StoreShippingAddressRequest;
use App\Http\Requests\InvoiceFileStore;
use App\Http\Requests\Invoices\StoreInvoice;
use App\Inventory;
use App\Invoice;
use App\InvoiceItems;
use App\InvoiceSetting;
use App\Notifications\ItemDecreased;
use App\Notifications\PaymentReminder;
use App\OfflineInvoicePayment;
use App\Payment;
use App\Product;
use App\Project;
use App\Proposal;
use App\Scopes\CompanyScope;
use App\Tax;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Invoices\UpdateInvoice;
use App\Notifications\NewInvoice;
use App\ProjectMilestone;
use App\ProjectTimeLog;
use App\StockRequest;
use App\StockTransaction;
use stdClass;

class ManageStocksController extends AdminBaseController
{ 
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Stocks';
        $this->pageIcon = 'ti-receipt';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('inventories', $this->user->modules),403);
            return $next($request);
        });
        $this->middleware('permission:add_inventories')->only('store');
        $this->middleware('permission:edit_inventories')->only('edit','approveRequest','Request','saveRequest');
        $this->middleware('permission:view_inventories')->only('show','index');
    }
    public function index(RequestsDataTable $dataTable)
    {
        $this->projects = Project::all();
        $this->clients = User::allClients();
        return $dataTable->render('admin.stocks.requests', $this->data);
    }
    public function Request($request_type)
    {   
        // dd($request_type);
        $this->projects = Project::whereNotNull('client_id')->get();
        $this->currencies = Currency::all();
        $this->lastInvoice = Invoice::lastInvoiceNumber() + 1;
        $this->invoiceSetting = InvoiceSetting::first();
        $this->zero = '';
        if (strlen($this->lastInvoice) < $this->invoiceSetting->invoice_digit) {
            for ($i = 0; $i < $this->invoiceSetting->invoice_digit - strlen($this->lastInvoice); $i++) {
                $this->zero = '0' . $this->zero;
            }
        }
        $this->taxes = Tax::all();
        $this->products = Product::with('tax')
        ->join('product_inventories','products.id','=','product_inventories.product')
        ->join('inventories','inventories.id','=','product_inventories.inventory')
        ->select('product_inventories.id',DB::raw("CONCAT(inventories.name,' - ',products.name) AS title"),
                 DB::raw("CONCAT(inventories.name,' - ',products.name) AS text"))
        ->get();

        $this->clients = User::allClients();
        $invoice = new Invoice();
        $this->fields = $invoice->getCustomFieldGroupsWithFields()->fields;
        return view('admin.stocks.request', $this->data,compact('request_type'));
    }
   
    public function saveRequest(Request $request,$request_type)
    {

        $user =  \Auth::user();
        $user_id = $user->id;
        $isAdmin = $user->hasRole('admin');
        // dd("request");
        $items_id = $request->input('item_id');
        $items = $request->input('item_name');
        $itemsSummary = $request->input('item_summary');
        $items_name = $request->input('item_name');
        $cost_per_item = $request->input('cost_per_item');
        $quantity = $request->input('quantity');
        $hsnSacCode = request()->input('hsn_sac_code');
        $amount = $request->input('amount');
        $tax = $request->input('taxes');
        $products = []; 
        $i =0;
        if ($request_type === "retrieved") {
            $request_type = $this->getRetrieve_type($request, $request_type);
        }

        foreach ($items_id as $item_id ) {
            $product = new stdClass();
            if($item_id){
                $product->id = $item_id;
            }else{
                $product->id = null;
            }
            $product->name = $items_name[$i];
            $product->quantity = $quantity[$i];
            $i++;
            array_push($products,$product);
        }

        if ($quantity) {
            foreach ($quantity as $qty) {
                if (!is_numeric($qty) && (intval($qty) < 1)) {
                    return Reply::error(__('messages.quantityNumber'));
                }
            }
        } else {
            return Reply::error(__('messages.noLogTimeFound'));
        }
        foreach ($cost_per_item as $rate) {
            if (!is_numeric($rate)) {
                return Reply::error(__('messages.unitPriceNumber'));
            }
        }

        foreach ($amount as $amt) {
            if (!is_numeric($amt)) {
                return Reply::error(__('messages.amountNumber'));
            }
        }

        if ($items) {
            foreach ($items as $itm) {
                if (is_null($itm)) {
                    return Reply::error(__('messages.itemBlank'));
                }
            }
        } else {
            return Reply::error(__('messages.noLogTimeFound'));
        }
        $stock_request =new StockRequest();
       
        $stock_request->project_id = $request->project_id ?? null;
        $stock_request->client_id = ($request->client_id) ? $request->client_id : null;
        $stock_request->total = round($request->sub_total, 2);
        $today =  date("Y-m-d") ;
        $stock_request->issue_date =  $today;
        $stock_request->currency_id = $request->currency_id;
        $stock_request->created_by = $user_id;
        $stock_request->products = json_encode($products);

        if($isAdmin){

            $this->makeApproval($stock_request, $user_id, $request_type);




            //log search
            $this->checkProducts();
            $this->logSearchEntry($stock_request->id, 'Invoice ', 'admin.all-invoices.show', 'invoice');
            return Reply::redirect(route('admin.stocks.show-requests'), 'Request Created and Approved');
        }

        $request_type = DB::table('request_types')
            ->where('name', $request_type)->get()[0]->id;
        $stock_request->type =  $request_type;

        $stock_request->save();

        $this->checkProducts();

        return Reply::redirect(route('admin.stocks.show-requests'), __('modules.stocks.request_created'));
    }
    public function approveRequest($request_type,$id)
    {   

        $user =  \Auth::user();
        $user_id = $user->id;
        $isAdmin = $user->hasRole('admin');
        $stock_request =  StockRequest::findOrFail($id);
        if ($isAdmin){
            $this->makeApproval($stock_request, $user_id, $request_type);
            $this->checkProducts();
        }
         return redirect()->back();
    }
    public function edit($id)
    {
        $this->invoice = Invoice::findOrFail($id)->withCustomFields();
        $this->fields = $this->invoice->getCustomFieldGroupsWithFields()->fields;

        $this->projects = Project::all();
        $this->currencies = Currency::all();

        if ($this->invoice->status == 'paid') {
            abort(403);
        }
        $this->taxes = Tax::all();
        $this->products = Product::select('id', 'name as title', 'name as text')->get();
        $this->clients = User::allClients();

        if ($this->invoice->project_id != '') {
            $companyName = Project::where('id', $this->invoice->project_id)->with('clientdetails')->withTrashed()->first();
                $this->companyName = $companyName->clientdetails ? $companyName->clientdetails->company_name : '';
                $this->clientId = $companyName->clientdetails ? $companyName->clientdetails->user_id : '';
        }

        return view('admin.invoices.edit', $this->data);
    }

    public function addItems(Request $request)
    {
        // dd ("reda");
        // $this->items = Product::with('tax')->find($request->id);
        $added_product = new stdClass();
        $added_product->id = $request->id;
        $added_product->quantity = "test";
        
        $this->items =  Product::with('tax')
        ->join('product_inventories','products.id','=','product_inventories.product')
        ->where('product_inventories.id',$request->id)
        ->get()[0];
        // dd( $this->items);
        $exchangeRate = Currency::find($request->currencyId);

        if (!is_null($exchangeRate) && !is_null($exchangeRate->exchange_rate)) {
            if ($this->items->total_amount != "") {
                $this->items->price = floor($this->items->total_amount * $exchangeRate->exchange_rate);
            } else {
                $this->items->price = $this->items->price * $exchangeRate->exchange_rate;
            }
        } else {
            if($this->items != '' && $this->items != null){
                if ($this->items->total_amount != "") {
                    $this->items->price = $this->items->total_amount;
                }
             }
        }
        $this->items->price =  number_format((float)$this->items->price, 2, '.', '');

        $this->taxes = Tax::all();
        $view = view('admin.invoices.add-item', $this->data)->render();
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function checkShippingAddress()
    {
        if (request()->has('clientId')) {
            $user = User::findOrFail(request()->clientId);
            if (request()->showShipping == 'yes' && (is_null($user->client_details->shipping_address) || $user->client_details->shipping_address === '')) {
                $view = view('admin.invoices.show_shipping_address_input')->render();
                return Reply::dataOnly(['view' => $view]);
            } else {
                return Reply::dataOnly(['show' => 'false']);
            }
        } else {
            return Reply::dataOnly(['switch' => 'off']);
        }
    }

    public function toggleShippingAddress(Invoice $invoice)
    {
        if ($invoice->show_shipping_address === 'yes') {
            $invoice->show_shipping_address = 'no';
        } else {
            $invoice->show_shipping_address = 'yes';
        }

        $invoice->save();

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function shippingAddressModal(Invoice $invoice)
    {
        $clientId = $invoice->clientdetails ? $invoice->clientdetails->user_id : $invoice->project->clientdetails->user_id;

        return view('sections.add_shipping_address', ['clientId' => $clientId]);
    }

    public function addShippingAddress(StoreShippingAddressRequest $request, User $user)
    {
        $user->client_details->shipping_address = $request->shipping_address;

        $user->client_details->save();

        return Reply::success(__('messages.addedSuccessfully'));
    }




    public function getClient($projectID)
    {
        $companyName = Project::with('client')->find($projectID);
        return $companyName->client->company_name;
    }

    public function getClientOrCompanyName($projectID = '')
    {
        $this->projectID = $projectID;

        if ($projectID == '') {
            $this->clients = User::allClients();
        } else {
            $companyName = Project::where('id', $projectID)->with('clientdetails')->first();
            $this->companyName = $companyName->clientdetails ? $companyName->clientdetails->company_name : '';
            $this->clientId = $companyName->clientdetails ? $companyName->clientdetails->user_id : '';
        }

        $list = view('admin.invoices.client_or_company_name', $this->data)->render();
        return Reply::dataOnly(['html' => $list]);
    }



    private function calculateTransactionState($prev , $current){
      if($prev === $current)
      return 0;
      elseif($prev > $current)
      return -1;
      return 1;
    }
    private function checkProducts(){
        $admins = User::whereHas('roles', function ($query) {
            $query->where('name', 'Admin');
        })->get();
        $products = DB::table('product_inventories')
            ->join('products', 'products.id', '=', 'product_inventories.product')
            ->select('products.name','product_inventories.*')
            ->get();
        foreach ($products as $product){
            if ($product->item_in_stock < 4){
                Notification::send($admins, new ItemDecreased($product));
            }
        }
    }

    /**
     * @param $request_product
     */
    private function makeWithdraw($request_product): void
    {
        $today = date("Y-m-d");
        $current_stock = DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->get('item_in_stock')[0]->item_in_stock;
        $new_transaction = StockTransaction::firstOrNew(array('product' => $request_product->id, 'date' => $today));
        $new_transaction->current = $current_stock - $request_product->quantity;
        $today_found = StockTransaction::where('product', '=', $request_product->id)->where('date', '=', $today)->first();

        $prev = 0;
        //    dd($today_$;
        if ($today_found == null) {
            $last_day_count = StockTransaction::select('current')->where('product', $request_product->id)->orderBy('date', 'desc')->first();
            $prev = $last_day_count === null ? $current_stock : $last_day_count->current;
            $new_transaction->prev = $prev;
        } else {
            $prev = $today_found->prev;
        }
        $new_transaction->state = $this->calculateTransactionState($prev, $current_stock - $request_product->quantity);
        $new_transaction->save();

        DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->update(array('item_in_stock' => $current_stock - $request_product->quantity));
    }

    /**
     * @param $request_product
     * @param $column
     */
    private function makeRetrieve($request_product, $column): void
    {
        if($column === 'retrieved'){
            $column = "item_in_stock";
        }
        $today = date("Y-m-d");
        $current_stock = DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->get('item_in_stock')[0]->item_in_stock;

        $today_found = StockTransaction::where('product', '=', $request_product->id)->where('date', '=', $today)->first();
        $new_transaction = StockTransaction::firstOrNew(array('product' => $request_product->id, 'date' => $today));
        if ($column === "item_in_stock") {

            $new_transaction->current = $current_stock + $request_product->quantity;
            $today_found = StockTransaction::where('product', '=', $request_product->id)->where('date', '=', $today)->first();
            $prev = 0;

            if ($today_found == null) {
                $last_day_count = StockTransaction::select('current')->where('product', $request_product->id)->orderBy('date', 'desc')->first();
                $prev = $last_day_count === null ? 0 : $last_day_count->current;
                $new_transaction->prev = $prev;
            } else {
                $prev = $today_found->prev;
            }

            $new_transaction->state = $this->calculateTransactionState($prev, $current_stock + $request_product->quantity);
            $new_transaction->save();
        }

        DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->increment($column, $request_product->quantity);
    }

    /**
     * @param $request_product
     * @param string $column
     */
    private function decreaseItemsinStock($request_product, string $column): void
    {
        $today = date("Y-m-d");
        $current_stock = DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->get('item_in_stock')[0]->item_in_stock;
        $new_transaction = StockTransaction::firstOrNew(array('product' => $request_product->id, 'date' => $today));
        $new_transaction->current = $current_stock - $request_product->quantity;
        $today_found = StockTransaction::where('product', '=', $request_product->id)->where('date', '=', $today)->first();
        $prev = 0;

        if ($today_found == null) {
            $last_day_count = StockTransaction::select('current')->where('product', $request_product->id)->orderBy('date', 'desc')->first();
            $prev = $last_day_count === null ? 0 : $last_day_count->current;
            $new_transaction->prev = $prev;
        } else {
            $prev = $today_found->prev;
        }
        $new_transaction->state = $this->calculateTransactionState($prev, $current_stock - $request_product->quantity);
        $new_transaction->save();

        DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->update(array('item_in_stock' => $current_stock - $request_product->quantity));
        DB::table('product_inventories')
            ->where('id', $request_product->id)
            ->increment($column, $request_product->quantity);
    }



    /**
     * @param $stock_request
     * @param $user_id
     * @param $request_type
     */
    private function makeApproval($stock_request, $user_id, $request_type): void
    {
        $stock_request->approved = 1;
        $stock_request->approved_by = $user_id;
        $request_products = json_decode($stock_request->products);
        if ($request_type === "withdraw") {
            foreach ($request_products as $request_product) {

                if ($request_product->id != null) {
                    $this->makeWithdraw($request_product);
                }
            }
        } elseif ($request_type === "retrieved" || $request_type === "damaged" || $request_type === "old") {
            foreach ($request_products as $request_product) {
                if ($request_product->id != null) {
                    $this->makeRetrieve($request_product, $request_type);
                }
            }

        } elseif ($request_type === "scraped" || $request_type === "consumed") {
            $column = $request_type === "scraped" ? "scraped" : "consumed";
            foreach ($request_products as $request_product) {
                if ($request_product->id != null) {
                    $this->decreaseItemsinStock($request_product, $column);
                }
            }

        }
        $request_type = DB::table('request_types')
            ->where('name', $request_type)->get()[0]->id;
        $stock_request->type =  $request_type;
        $stock_request->save();
    }

    /**
     * @param Request $request
     * @param $request_type
     * @return mixed
     */
    private function getRetrieve_type(Request $request, $request_type)
    {
        $column = "item_in_stock";
        if ($request->retrive_type !== null) {
            $request_type = $request->retrive_type;
            $column = $request->retrive_type;
        }
        return $request_type;
    }
}
