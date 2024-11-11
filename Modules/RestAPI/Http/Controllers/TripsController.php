<?php

namespace Modules\RestAPI\Http\Controllers;

use App\Currency;
use App\Helper\Reply;
use App\Invoice;
use App\InvoiceItems;
use App\memberDetails;
use App\Notifications\NewInvoice;
use App\TripMember;
use App\Trips;
use Carbon\Carbon;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;

class TripsController extends ApiBaseController
{
    protected $model = Trips::class;
    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;

    public function index()
    {
        app()->make($this->indexRequest);
        $events=Trips::all();
        $results = [
            'events'=>$events
        ];

        return ApiResponse::make(null, $results);
    }

    public function show(...$args){
        $event=Trips::find($args);
        $member=memberDetails::where('user_id',auth()->user()->id)->first();
        $familyMembers=memberDetails::where('family_id',$member->family_id)->select('user_id','name')->get()->except('user_id' , auth()->user()->id);

        $results = [
            'event'=>$event,
            'familyMembers'=>$familyMembers
        ];

        return ApiResponse::make(null, $results);
    }
    public function subscribe(Request $request ,$id){




        $subscribedSessions=TripMember::where('trip_id' , $id)->get();
        $sportSession=Trips::where('id' , $id)->first();
        $user_id= $request->input('user_id') ? $request->input('user_id') : auth()->user()->id;
        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $i++;
        }

        $user =  \Auth::user();





        if (!in_array($user_id,$subscribers )) {
            if ($sportSession->available != 0) {
                $invoice = new Invoice();
                $invoice->project_id = $request->project_id ?? null;
                $invoice->client_id = $user->id;
                $invoice->invoice_number = Invoice::lastInvoiceNumber() + 1;
                $invoice->issue_date = Carbon::now();
                $invoice->due_date = Carbon::now();
                $invoice->sub_total = round($sportSession->member_fees, 2);
                $invoice->discount = 0;
                $invoice->discount_type = 'percent';
                $invoice->total = round($sportSession->member_fees, 2);
                $invoice->currency_id = Currency::where('currency_code',$sportSession->currency)->first()->id;
                $invoice->recurring = 'no';
                $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
                $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
                $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
                $invoice->note = $request->note;
                $invoice->show_shipping_address = 'no';
                $invoice->created_by = $user->id;
                $invoice->save();
                InvoiceItems::create(
                    [
                        'invoice_id' => $invoice->id,
                        'item_name' => $sportSession->trip_name.' #'.$sportSession->id,
                        'item_summary' => '',
                        'hsn_sac_code' =>  null,
                        'type' => 'item',
                        'quantity' => 1.00,
                        'unit_price' => round($sportSession->member_fees, 2),
                        'amount' => round($sportSession->member_fees, 2),
                        'taxes' =>null
                    ]
                );
                $notifyUser = $invoice->client;
                if (!is_null($notifyUser)) {
                    $notifyUser->notify(new NewInvoice($invoice));
                }

                $invoice->send_status = 1;
                $invoice->save();
                $subscribe = new TripMember();
                $subscribe->user_id = $user_id;
                $subscribe->trip_id = $id;
                $sportSession->available--;
                $subscribe->save();
                $sportSession->save();
                return ApiResponse::make(__('messages.subscription_done') );
            } else {
                return ApiResponse::make(__('messages.sorry_not_available'));
            }
        }
        else{
            return ApiResponse::make(__('messages.user_subscribed_already'));

        }

    }

}