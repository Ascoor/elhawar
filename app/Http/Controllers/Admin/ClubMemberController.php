<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\AttendanceSetting;
use App\Currency;
use App\DataTables\Admin\FamilyDatatTable;
use App\DataTables\Club\FamilyMembersDataTable;
use App\DataTables\Admin\ViewMemberDataTable;
use App\EmployeeDetails;
use App\Helper\Reply;
use App\Holiday;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Controllers\Club\ClubBaseController;
use App\Invoice;
use App\InvoiceItems;
use App\Leave;
use App\Level;
use App\Location;
use App\memberCategory;
use App\memberDetails;
use App\memberRelations;
use App\memberStatus;
use App\Notifications\NewInvoice;
use App\PlayerGroup;
use App\SessionMember;
use App\SportAcademy;
use App\SportSession;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClubMemberController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->pageTitle = 'app.menu.sessions_calender';
        $this->pageIcon = 'icon-calender';

        $this->attendanceSettings = AttendanceSetting::first();

        //Getting Maximum Check-ins in a day
        $this->maxAttandenceInDay = $this->attendanceSettings->clockin_in_day;
    }

    public function subscribe(Request $request ,$id , $subscriber_id=null){
        $user =  \Auth::user();
        $sportSession=SportSession::where('id' , $id)->first();
        $relatedSessions=SportSession::where('session_id' ,$sportSession->session_id )->get();

        $subscribedSessions=SessionMember::where('session_id' , $sportSession->session_id)->get();
        if ( $request->input('member_id')) {
           if (memberDetails::where('member_id',$request->input('member_id'))->first()) {
               $user_id = memberDetails::where('member_id', $request->input('member_id'))->first()->user_id;
           }else{
               return Reply::error(__('messages.user_not_exist'));
           }
        }else{
            $user_id=$subscriber_id;
        }
        $subscribers=array();
        $i=0;
        foreach ($subscribedSessions as $session){
            $subscribers[$i]=$session->user_id;
            $statusarr[$i]=$session->status;
            $i++;
        }
        if (memberDetails::where('user_id',$user_id)->first()) {
            if (!in_array($user_id, $subscribers) || $subscribedSessions->where('user_id', $user_id)->first()->status == 'waiting') {
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
                    $invoice->currency_id = Currency::where('currency_code', $sportSession->currency)->first()->id;
                    $invoice->recurring = 'no';
                    $invoice->billing_frequency = $request->recurring_payment == 'yes' ? $request->billing_frequency : null;
                    $invoice->billing_interval = $request->recurring_payment == 'yes' ? $request->billing_interval : null;
                    $invoice->billing_cycle = $request->recurring_payment == 'yes' ? $request->billing_cycle : null;
                    $invoice->note = 'paid for ' . User::find($user_id)->name;
                    $invoice->show_shipping_address = 'no';
                    $invoice->created_by = $user->id;
                    $invoice->save();
                    InvoiceItems::create(
                        [
                            'invoice_id' => $invoice->id,
                            'item_name' => $sportSession->session_name . ' #' . $sportSession->session_id,
                            'item_summary' => '',
                            'hsn_sac_code' => null,
                            'type' => 'item',
                            'quantity' => 1.00,
                            'unit_price' => round($sportSession->fees, 2),
                            'amount' => round($sportSession->fees, 2),
                            'taxes' => null
                        ]
                    );
                    $notifyUser = $invoice->client;
                    if (!is_null($notifyUser)) {
                        $notifyUser->notify(new NewInvoice($invoice));
                    }

                    $invoice->send_status = 1;
                    $invoice->save();
                    if ($subscribedSessions->where('user_id', $user_id)->first() && $subscribedSessions->where('user_id', $user_id)->first()->status == 'waiting') {
                        $subscribe = $subscribedSessions->where('user_id', $user_id)->first();
                        $subscribe->status = 'subscription';
                        $subscribe->save();
                        foreach ($relatedSessions as $relatedSession) {
                            $relatedSession->waiting--;
                            $relatedSession->save();
                        }
                    } else {
                        $subscribe = new SessionMember();
                        $subscribe->user_id = $user_id;
                        $subscribe->session_id = $sportSession->session_id;
                        $subscribe->status = 'subscription';
                        $subscribe->save();
                    }
                    foreach ($relatedSessions as $relatedSession) {
                        $relatedSession->available--;
                        $relatedSession->save();

                    }
                    return Reply::success(__('messages.subscription_done'));
                } else {
                    if (!in_array($user_id, $subscribers)) {
                        $subscribe = new SessionMember();
                        $subscribe->user_id = $user_id;
                        $subscribe->session_id = $sportSession->session_id;
                        $subscribe->status = 'waiting';
                        $subscribe->save();
                        foreach ($relatedSessions as $relatedSession) {
                            $relatedSession->waiting++;
                            $relatedSession->save();
                        }
                        return Reply::success(__('messages.added_to_waiting_list'));
                    } else {
                        return Reply::error(__('messages.not_available'));

                    }
                }
            } else {
                return Reply::error(__('messages.user_subscribed_already'));

            }
        }else{
            return Reply::error(__('messages.user_not_exist'));
        }

    }


}