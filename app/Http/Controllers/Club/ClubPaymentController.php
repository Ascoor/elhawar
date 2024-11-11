<?php

namespace App\Http\Controllers\Club;

use App\Http\Controllers\Client\ClientBaseController;
use App\Invoice;
use App\memberDetails;
use App\Payment;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClubPaymentController extends ClubBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.payments';
        $this->pageIcon = 'fa fa-money';

        $this->middleware(function ($request, $next) {
            abort_if(!in_array('payments', $this->user->modules),403);
            return $next($request);
        });
    }

    public function index()
    {
        $this->projects = Project::where('client_id', $this->user->id)->get();
        return view('club.payments.index', $this->data);
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function data(Request $request)
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
        if ($invoices) {
            foreach ($invoices as $invoice) {
                $invoicesIds[$i] = $invoice->id;
                $i++;
            }
        }
        $payments = Payment::join('invoices' , 'invoices.id', '=' , 'payments.invoice_id')
            ->join('currencies', 'currencies.id', '=', 'payments.currency_id')
            ->whereIn('payments.invoice_id', $invoicesIds)
            ->select('payments.invoice_id','payments.id', 'payments.project_id', 'payments.amount', 'currencies.currency_symbol', 'currencies.currency_code', 'payments.status', 'payments.paid_on', 'payments.remarks', 'payments.transaction_id','invoices.invoice_number');

        if ($request->startDate !== null && $request->startDate != 'null' && $request->startDate != '') {
            $startDate = Carbon::createFromFormat($this->global->date_format, $request->startDate)->toDateString();
            $payments = $payments->where(DB::raw('DATE(payments.`paid_on`)'), '>=', $startDate);
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
            $payments = $payments->where(DB::raw('DATE(payments.`paid_on`)'), '<=', $endDate);
        }

        if ($request->project != 'all' && !is_null($request->project)) {
            $payments = $payments->where('payments.project_id', '=', $request->project);
        }


//        $payments = $payments->whereIn('payments.invoice_id', $invoicesIds);
//        $payments = $payments->where('payments.status', '=', 'complete');

        $payments = $payments->orderBy('payments.id', 'desc')->get()->unique();
        //return response()->json($payments->toArray());

        return DataTables::of($payments)
            ->editColumn('remarks', function($row) {
                return ucfirst($row->remarks);
            })

            ->editColumn('project_id', function($row) {
                if ($row->project_id != null) {
                    return '<a href="' . route('club.projects.show', $row->project_id) . '">' . ucfirst($row->project_name) . '</a>';
                } else {
                    return '--';
                }

            })
            ->editColumn('amount', function ($row) {
                return currency_formatter($row->amount,$row->currency_symbol).' ('.$row->currency_code.')';
            })
            ->editColumn(
                'paid_on',
                function ($row) {
                    if(!is_null($row->paid_on)){
                        return $row->paid_on->format($this->global->date_format .' '. $this->global->time_format);
                    }
                }
            )
            ->editColumn('status', function ($row) {
                if ($row->status == 'pending') {
                    return '<label class="label label-warning">' . strtoupper($row->status) . '</label>';
                } else {
                    return '<label class="label label-success">' . strtoupper($row->status) . '</label>';
                }
            })
            ->editColumn('invoice_number', function ($row) {
                if ($row->invoice_id != null && !is_null($row->invoice)) {
                    return '<a href="javascript:;" class="view-payment" data-payment-id="' . $row->id . '">' . $row->invoice->invoice_number . '</a>';
                }
                return '--';
            })
            ->rawColumns(['status', 'project_id','invoice_number'])
            ->removeColumn('invoice_id')
            ->removeColumn('currency_symbol')
            ->removeColumn('currency_code')
            ->removeColumn('project_name')
            ->make(true);
    }
}