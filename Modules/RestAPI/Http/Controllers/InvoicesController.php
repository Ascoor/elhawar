<?php

namespace Modules\RestAPI\Http\Controllers;

use App\Invoice;
use App\memberDetails;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class InvoicesController extends ApiBaseController
{
    protected $model = Invoice::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familyMembers=$member->family();
        $familyMembersIds=array();
        $i=0;
        foreach ($familyMembers as $familyMember){
            $familyMembersIds[$i]=$familyMember->user_id;
            $i++;
        }
        $invoices=Invoice::whereIn('client_id' ,$familyMembersIds )->join('invoice_items','invoice_items.invoice_id','=','invoices.id')->select('invoices.id','invoice_number','total','status','issue_date','note','invoice_items.item_name')->get();
        $results = [
            'invoices'=>$invoices
        ];

        return ApiResponse::make(null, $results);
    }
    public function show(...$args)
    {
        $invoice=Invoice::where('invoices.id' ,$args )->join('invoice_items','invoice_items.invoice_id','=','invoices.id')->select('invoices.id','invoice_number','total','status','issue_date','note','invoice_items.item_name')->first();
        $results = [
            'invoice'=>$invoice
        ];
        return ApiResponse::make(null, $results);
    }
}