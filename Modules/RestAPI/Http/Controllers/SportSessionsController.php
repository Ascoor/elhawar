<?php

namespace Modules\RestAPI\Http\Controllers;
use App\Currency;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Invoice;
use App\InvoiceItems;
use App\Level;
use App\Location;
use App\memberDetails;
use App\Notifications\NewInvoice;
use App\PlayerGroup;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use App\User;
use Carbon\Carbon;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;
use Modules\RestAPI\Http\Requests\Event\CreateRequest;
use Modules\RestAPI\Http\Requests\Event\DeleteRequest;
use Modules\RestAPI\Http\Requests\Event\IndexRequest;
use Modules\RestAPI\Http\Requests\Event\ShowRequest;
use Modules\RestAPI\Http\Requests\Event\UpdateRequest;
class SportSessionsController extends ApiBaseController
{
    protected $model = SportAcademy::class;
    protected $indexRequest = IndexRequest::class;
    protected $storeRequest = CreateRequest::class;
    protected $updateRequest = UpdateRequest::class;
    protected $showRequest = ShowRequest::class;
    protected $deleteRequest = DeleteRequest::class;
    public function index()
    {
        app()->make($this->indexRequest);
        $sportSession=SportSession::all();
        $sports = SportAcademy::all();
        $currencies=Currency::all();
        $levels = Level::all();
        $groups = PlayerGroup::all();
        $locations = Location::all();
        $coaches=EmployeeDetails::where('designation_id' , 1)->get();
        $results = [
            'sports' => $sports,
            'currencies'=>$currencies,
            'levels'=>$levels,
            'groups'=>$groups,
            'locations'=>$locations,
            'coaches'=>$coaches,
            'sesseions'=>$sportSession

        ];



        return ApiResponse::make(null, $results);
    }
    public function showSession($id){
        app()->make($this->showRequest);
        $session=SportSession::where('id',$id)->first();
        if (!$session){
            return ApiResponse::make(__('messages.session_doesnt_exist'));
        }else{
        $startDate = explode(' ', request('start'));
        $startDate = Carbon::parse($startDate[0]);
        $member=memberDetails::where('user_id' , auth()->user()->id)->first();
        $members=$member->family();
        $coach=EmployeeDetails::where('user_id' ,$session->coach_id )->first();
        $location=Location::where('id',$session->location_id)->first();
        $sport=SportAcademy::where('id',$session->sport_id)->first();
        $level=Level::where('id',$session->level_id)->first();
        $group=PlayerGroup::where('id',$session->group_id)->first();
        $subscribedSessions=SessionMember::where('session_id' , $session->session_id)->get();
        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $i++;
        }
        $sessionSubscribers=$subscribers;





        $results = [
            'startDate'=>$startDate,
            'members'=>$members,
            'sport' => $sport,
            'level'=>$level,
            'group'=>$group,
            'location'=>$location,
            'coach'=>$coach,
            'subscribers'=>$sessionSubscribers
        ];

        return ApiResponse::make(null, $results);
        }
    }
    public function subscribe(Request $request ,$id){
        $user =  \Auth::user();
        $sportSession=SportSession::where('id' , $id)->first();
        $relatedSessions=SportSession::where('session_id' ,$sportSession->session_id )->get();

        $subscribedSessions=SessionMember::where('session_id' , $sportSession->session_id)->get();
        $user_id = $request->input('user_id') ? $request->input('user_id') : auth()->user()->id;

        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $i++;
        }
        if (!in_array($user_id,$subscribers )) {
            if ($sportSession->available != 0) {
                $invoice = new Invoice();
                $invoice->project_id = $request->project_id ?? null;
                $invoice->client_id = $user->id;
                $invoice->invoice_number = Invoice::lastInvoiceNumber() + 1;
                $invoice->issue_date = Carbon::now();
                $invoice->due_date = Carbon::now();
                $invoice->sub_total = round($sportSession->fees, 2);
                $invoice->discount = 0;
                $invoice->discount_type = 'percent';
                $invoice->total = round($sportSession->fees, 2);
                $invoice->currency_id = Currency::where('currency_code',$sportSession->currency)->first()->id;
                $invoice->recurring = 'no';
                $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
                $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
                $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
                $invoice->note = 'paid for '.User::find($user_id)->name;
                $invoice->show_shipping_address = 'no';
                $invoice->created_by = $user->id;
                $invoice->save();
                InvoiceItems::create(
                    [
                        'invoice_id' => $invoice->id,
                        'item_name' => $sportSession->session_name.' #'.$sportSession->session_id,
                        'item_summary' => '',
                        'hsn_sac_code' =>  null,
                        'type' => 'item',
                        'quantity' => 1.00,
                        'unit_price' => round($sportSession->fees, 2),
                        'amount' => round($sportSession->fees, 2),
                        'taxes' =>null
                    ]
                );
                $notifyUser = $invoice->client;
                if (!is_null($notifyUser)) {
                    $notifyUser->notify(new NewInvoice($invoice));
                }

                $invoice->send_status = 1;
                $invoice->save();
                $subscribe = new SessionMember();
                $subscribe->user_id = $user_id;
                $subscribe->session_id = $sportSession->session_id;
                $subscribe->status = 'subscription';
                $subscribe->save();
                foreach ($relatedSessions as $relatedSession) {
                    $relatedSession->available--;
                    $relatedSession->save();

                }
                return ApiResponse::make(__('messages.subscription_done'));
            } else {
                $subscribe = new SessionMember();
                $subscribe->user_id = $user_id;
                $subscribe->session_id = $sportSession->session_id;
                $subscribe->status = 'waiting';
                $subscribe->save();
                foreach ($relatedSessions as $relatedSession) {
                    $relatedSession->waiting++;
                    $relatedSession->save();
                }
                return ApiResponse::make(__('messages.added_to_waiting_list'));
            }
        }
        else{
            return ApiResponse::make(__('messages.user_subscribed_already'));

        }

    }


}