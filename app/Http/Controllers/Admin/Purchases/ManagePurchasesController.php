<?php

namespace App\Http\Controllers\Admin\Purchases;
use App\Http\Controllers\Admin\AdminBaseController;
use App\ClientPayment;
use App\CreditNotes;
use App\Currency;
use App\DataTables\Admin\PurchasesDataTable;
use App\Estimate;
use App\Events\PaymentReminderEvent;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\Admin\Client\StoreShippingAddressRequest;
use Illuminate\Support\Facades\View;
use App\Invoice;
use App\InvoiceItems;
use App\InvoiceSetting;
use App\Notifications\ItemDecreased;

use App\Payment;
use App\Product;
use App\Project;
use App\Proposal;
use App\PurchaseRequest;
use App\Scopes\CompanyScope;
use App\Tax;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use stdClass;

class ManagePurchasesController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'Purchases';
        $this->pageIcon = 'ti-receipt';
        $this->middleware(function ($request, $next) {
            abort_if(!in_array('invoices', $this->user->modules),403);
            return $next($request);
        });
    }
    public function index(PurchasesDataTable $dataTable)
    {
        $this->projects = Project::all();
        $this->clients = User::allClients();
        $this->purchase_requests = PurchaseRequest::all();
        //dd($this->data);
        return $dataTable->render('admin.purchases.requests', $this->data);
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
        return view('admin.purchases.request', $this->data,compact('request_type'));
    }
   
    public function saveRequest(Request $request,$request_type)
    { 
        $user =  \Auth::user();
        $user_id = $user->id;
        $isAdmin = $user->hasRole('admin');
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
//         return $items_id;
        foreach ($items_id as $item_id ) {
            $product = new stdClass();
            if($item_id){
                $product->id = $item_id;
            }else{
                $product->id = null;
            }
            $product->name = $items_name[$i];
            $product->quantity = $quantity[$i];
            $product->itemsSummary = $itemsSummary[$i];
            $product->cost_per_item = $cost_per_item[$i];
            $i++;
            array_push($products,$product);
        }
//        return $products;
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
        $purchase_request =new PurchaseRequest();

        $purchase_request->project_id = $request->project_id ?? null;
        $purchase_request->client_id = ($request->client_id) ? $request->client_id : null;
        $purchase_request->total = round($request->sub_total, 2);
        $today =  date("Y-m-d") ;
        $purchase_request->issue_date =  $today;
        $purchase_request->currency_id = $request->currency_id;
        $purchase_request->created_by = $user_id;
        $purchase_request->products = json_encode($products);
        if($isAdmin){
            $purchase_request->approved = 1;
            $purchase_request->approved_by = $user_id;
            $purchase_request->type =  'purchase';
            $purchase_request->save();
            //log search
            $this->checkProducts();
            $this->logSearchEntry($purchase_request->id, 'Invoice ', 'admin.all-invoices.show', 'invoice');
            return Reply::redirect(route('admin.purchases.show-requests'), 'Purchase Request Created and Approved');
        } else {
            $purchase_request->approved = 0;
            
            $purchase_request->type =  'purchase';
            $purchase_request->save();
            //log search
            $this->checkProducts();
            $this->logSearchEntry($purchase_request->id, 'Invoice ', 'admin.all-invoices.show', 'invoice');
            return Reply::redirect(route('admin.purchases.show-requests'), 'Purchase Request Created and Pending Approval');
        }
         $this->checkProducts();
        return Reply::redirect(route('admin.purchases.show-requests'), __('modules.purchases.request_created'));
    }
    public function approveRequest($id)
    {   
        
        $user =  \Auth::user();
        $user_id = $user->id;
        $isAdmin = $user->hasRole('admin');
        // if($isAdmin){
        //     DB::table('purchase_requests')
        //     ->where('id', $id)
        //     ->update(array('approved' => 1,'approved_by' => $user_id));
        // }
        if(auth()->user()->getUserOtherRoleAttribute()=="club_manger"){
            DB::table('purchase_requests')
            ->where('id', $id)
            ->update(array('approved' => 1,'approved_by' => $user_id));
        }elseif(auth()->user()->getUserOtherRoleAttribute()=="treasury"){
            DB::table('purchase_requests')
            ->where('id', $id)
            ->update(array('approved' => 2,'approved_by' => $user_id));
        }elseif(auth()->user()->getUserOtherRoleAttribute()=="ceo"){
            DB::table('purchase_requests')
            ->where('id', $id)
            ->update(array('approved' => 3,'approved_by' => $user_id));
        }else{
            return redirect()->back()->withErrors("Not Allowed");
        }
         return redirect()->back();
    }
    public function disApproveRequest($id)
    {   
        
        $user =  \Auth::user();
        $user_id = $user->id;
        $isAdmin = $user->hasRole('admin');
        // if($isAdmin){
        //     DB::table('purchase_requests')
        //     ->where('id', $id)
        //     ->update(array('approved' => 1,'approved_by' => $user_id));
        // }
        if(auth()->user()->getUserOtherRoleAttribute()=="club_manger"){
            DB::table('purchase_requests')
            ->where('id', $id)
            ->update(array('approved' => 31,'approved_by' => $user_id));
        }elseif(auth()->user()->getUserOtherRoleAttribute()=="treasury"){
            DB::table('purchase_requests')
            ->where('id', $id)
            ->update(array('approved' => 32,'approved_by' => $user_id));
        }elseif(auth()->user()->getUserOtherRoleAttribute()=="ceo"){
            DB::table('purchase_requests')
            ->where('id', $id)
            ->update(array('approved' => 33,'approved_by' => $user_id));
        }else{
            return redirect()->back()->withErrors("Not Allowed");
        }
         return redirect()->back();
    }
    public function printRequest($id)
    {
        $theRequest=PurchaseRequest::join('users','users.id','purchase_requests.created_by')
        ->select('purchase_requests.id',  'users.name as created_by',
         'purchase_requests.total', 'purchase_requests.products',
         'purchase_requests.issue_date','purchase_requests.approved' , 'purchase_requests.created_by as creator')
        ->where('purchase_requests.id',$id)
        ->first();
        if(!$theRequest) return "No Request found to be Printed";
        $ind=1;
        $this->contents=array();
        foreach (json_decode($theRequest->products,true) as $product){
            $content[$ind]['ind'] =' '.$ind;
            $content[$ind]['name'] = ' '.$product['name'];
            $content[$ind]['price'] = ' '.$product['cost_per_item'];
            $content[$ind]['summary'] = ' '.$product['itemsSummary'];
            $content[$ind]['totalprice'] = ' '.($product['cost_per_item']*$product['quantity']);
            $content[$ind]['quantity'] = ' '.$product['quantity'];
        $ind++;
        }
        
        
            

        $this->contents=$content;

        $now = Carbon::now();
        $year = $now->format('Y');
        $month = $now->format('m');
        $day = $now->format('d');
        $this->arabicTitle1='تصديق على طلب شراء    '.'بتاريخ '.$theRequest->issue_date;
        $this->arabicTitle2=' مقدم من السيد '.$theRequest->created_by;
        $this->arabicTitle3='للاصناف الاتية ';
        $this->printing_date=' تمت طباعة هذا التصديق بتارخ '.$day.' - '.$month.' - '.$year;
        $this->total='باجمالي '.$theRequest->total.'جنيها مصريا فقط لا غير';

        /////////
        $documentFileName = 'Salary Resources.pdf';
        $view = View::make('admin.purchases.printRequest', $this->data);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 10);
        $pdf->SetTitle('Report');
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->writeHTML($html_content, true, false, true, false, '');
        $pdf->Output($documentFileName);
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
    public function show($id)
    {
        $this->invoice = Invoice::with('project', 'project.client', 'clientdetails')->findOrFail($id)->withCustomFields();
        $this->fields = $this->invoice->getCustomFieldGroupsWithFields()->fields;
        $this->paidAmount = $this->invoice->getPaidAmount();
        $this->payments = Payment::with(['offlineMethod'])->where('invoice_id', $this->invoice->id)->where('status', 'complete')->orderBy('paid_on', 'desc')->get();


        if ($this->invoice->discount > 0) {
            if ($this->invoice->discount_type == 'percent') {
                $this->discount = (($this->invoice->discount / 100) * $this->invoice->sub_total);
            } else {
                $this->discount = $this->invoice->discount;
            }
        } else {
            $this->discount = 0;
        }

        $taxList = array();

        $items = InvoiceItems::whereNotNull('taxes')
            ->where('invoice_id', $this->invoice->id)
            ->get();
        foreach ($items as $item) {
            if ($this->invoice->discount > 0 && $this->invoice->discount_type == 'percent') {
                $item->amount = $item->amount - (($this->invoice->discount / 100) * $item->amount);
            }
            foreach (json_decode($item->taxes) as $tax) {
                $this->tax = InvoiceItems::taxbyid($tax)->first();
                if (!isset($taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'])) {
                    $taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'] = ($this->tax->rate_percent / 100) * $item->amount;
                } else {
                    $taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'] = $taxList[$this->tax->tax_name . ': ' . $this->tax->rate_percent . '%'] + (($this->tax->rate_percent / 100) * $item->amount);
                }
            }
        }

        $this->taxes = $taxList;

        $this->settings = $this->company;
        $this->invoiceSetting = InvoiceSetting::first();
        return view('admin.invoices.show', $this->data);
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
}
