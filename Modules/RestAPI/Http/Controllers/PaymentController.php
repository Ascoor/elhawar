<?php

namespace Modules\RestAPI\Http\Controllers;

use App\Invoice;
use App\memberDetails;
use App\Payment;
use Froiden\RestAPI\ApiResponse;
use Modules\RestAPI\Http\Requests\Invoice\CreateRequest;
use Modules\RestAPI\Http\Requests\Invoice\DeleteRequest;
use Modules\RestAPI\Http\Requests\Invoice\IndexRequest;
use Modules\RestAPI\Http\Requests\Invoice\ShowRequest;
use Modules\RestAPI\Http\Requests\Invoice\UpdateRequest;

class PaymentController extends ApiBaseController
{

    protected $model = Payment::class;

    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familyMembers=$member->family();
        $familyMembersIds=array();
        $y=0;
        foreach ($familyMembers as $familyMember){
            $familyMembersIds[$y]=$familyMember->user_id;
            $y++;
        }
        $invoices=Invoice::whereIn('client_id' , $familyMembersIds)->get();
        $i=0;
        foreach ($invoices as $invoice){
            $invoicesIds[$i]=$invoice->id;
            $i++;
        }
        $payments=Payment::whereIn('payments.invoice_id', $invoicesIds)->get();
        $results = [

            'payments'=>$payments

        ];



        return ApiResponse::make(null, $results);
    }
    public function show(...$args)
    {
        $payment=Payment::find($args);
        $results = [

            'payment'=>$payment

        ];



        return ApiResponse::make(null, $results);
    }

}