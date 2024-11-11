<?php

namespace Modules\Accounting\Http\Controllers;

use App\Http\Controllers\Admin\AdminBaseController;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use Modules\Accounting\Entities\Code;
use Modules\Accounting\Entities\DailyRecordsEntrie;

class Credebtors extends AdminBaseController {

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });

    }

    private function viewCommonAttributes()
    {
        $this->pageTitle = __('accounting::modules.accounting.accounting').' : '.__('accounting::modules.accounting.CreDebtors');
        $this->pageIcon = 'fa fa-money';

    }

    public function index(Request $request)
    {
        $this->viewCommonAttributes();


        if ($request->ajax()) {
           
            $query = Code::where('type', 'CREDIBTOR')->where('is_main','0');
            return DataTables::of($query)->make(true);
   
        }

        
        return view('accounting::credibtors.index',$this->data);
    }

    public function credibtorsheet($id,Request $request)
    {
        $this->viewCommonAttributes();

        $code=Code::findOrFail($id);
        
        $this->pageTitle .= ' / ' .$code->breadcrumb . ' / ' .__('accounting::modules.accounting.credebtorsheet');


        if($request->isMethod('get'))
        {
            return view('accounting::layouts.dateRangePickerForm',$this->data,['printChkBox'=>true]);
        }
        else
        {

            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
    
                ]
                );
    
            $startDate=(new Carbon($request->input('startDate')))->toDateString();
            $endDate=(new Carbon($request->input('endDate')))->toDateString();
            $this->data['startDate']=$startDate;
            $this->data['endDate']=$endDate;
            $this->data['breadcrumb']=$code->breadcrumb;

            $entries=DailyRecordsEntrie::with('dailyRecord')
            ->where('code_id',$code->id)
            ->whereHas('dailyRecord', function($query) use($startDate,$endDate) {
                $query/*->where('financial_reviewer_assign','=',1)
                ->where('financial_accountant_assign','=',1)
                ->where('financial_director_assign','=',1)*/
                ->whereBetween('date',[$startDate,$endDate]);
                return $query;
            })
            ->get()
            ->sortBy('dailyRecord.date');

            $sheetEntries=["date"=>[],"journalEntryNo"=>[],"journalEntryID"=>[],"transaction"=>[],"balance"=>[],'excerpt'=>[]];
            
            foreach($entries as $entry)
            {
                $amountIdentifier=($entry->type=='CREDIT')?-1:1;
             
                array_push($sheetEntries['date'],$entry->dailyRecord->date);
                array_push($sheetEntries['journalEntryNo'],$entry->dailyRecord->journalEntryNo);
                array_push($sheetEntries['journalEntryID'],$entry->dailyRecord->id);
                array_push($sheetEntries['excerpt'],$entry->dailyRecord->excerpt);
                array_push($sheetEntries['transaction'],$entry->amount);
                array_push($sheetEntries['balance'],empty($sheetEntries['balance'])?$amountIdentifier*$entry->amount:array_last($sheetEntries['balance'])+($amountIdentifier*$entry->amount));

            }

            $this->data['sheet']=$sheetEntries;

            if($request->has('print'))
            {
                return (new Report)->printPDF(__('accounting::modules.accounting.credebtorsheet'),"accounting::report.credibtorsheet",$this->data);

            }

            return view('accounting::credibtors.credibtorsheet',$this->data);

        }

    }


    public function generaledgersheet($id,Request $request)
    {
        $this->viewCommonAttributes();

        $code=Code::findOrFail($id);
        
        $this->pageTitle .= ' / ' .$code->breadcrumb . ' / ' .__('accounting::modules.accounting.generaledgersheet');
        
        if($request->isMethod('get'))
        {
            return view('accounting::layouts.dateRangePickerForm',$this->data,['printChkBox'=>true]);
        }
        else
        {

            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
    
                ]
                );
    
            $startDate=(new Carbon($request->input('startDate')))->toDateString();
            $endDate=(new Carbon($request->input('endDate')))->toDateString();
            $this->data['startDate']=$startDate;
            $this->data['endDate']=$endDate;
            $this->data['breadcrumb']=$code->breadcrumb;

            $entries=DailyRecordsEntrie::with('dailyRecord')
            ->where('code_id',$code->id)
            ->whereHas('dailyRecord', function($query) use($startDate,$endDate) {
                $query
                /*->where('financial_reviewer_assign','=',1)
                ->where('financial_accountant_assign','=',1)
                ->where('financial_director_assign','=',1)*/
                ->whereBetween('date',[$startDate,$endDate]);
                return $query;
            })
            ->get()
            ->sortBy('dailyRecord.date');

            $sheetEntries=["date"=>[],"journalEntryNo"=>[],"journalEntryID"=>[],"transaction"=>[],"balance"=>[],'excerpt'=>[]];
            $sheetTotals=["totalCreditor"=>0,"totalDebtor"=>0,"totalBalance"=>0];

            foreach($entries as $entry)
            {
                $amountIdentifier=($entry->type=='CREDIT')?-1:1;
             
                if($entry->type=='CREDIT'){$sheetTotals['totalCreditor']+=$entry->amount;}else{$sheetTotals['totalDebtor']+=$entry->amount;}

                array_push($sheetEntries['date'],$entry->dailyRecord->date);
                array_push($sheetEntries['journalEntryNo'],$entry->dailyRecord->journalEntryNo);
                array_push($sheetEntries['journalEntryID'],$entry->dailyRecord->id);
                array_push($sheetEntries['excerpt'],$entry->dailyRecord->excerpt);
                
                array_push($sheetEntries['transaction'],$amountIdentifier*$entry->amount);
                array_push($sheetEntries['balance'],empty($sheetEntries['balance'])?$amountIdentifier*$entry->amount:array_last($sheetEntries['balance'])+($amountIdentifier*$entry->amount));

            }

            $sheetTotals['totalBalance']=array_last($sheetEntries['balance']);
            
            $this->data['sheet']=$sheetEntries;
            $this->data['sheetTotals']=$sheetTotals;

            if($request->has('print'))
            {
                return (new Report)->printPDF(__('accounting::modules.accounting.generaledgersheet'),"accounting::report.generaledgersheet",$this->data);
            }

            return view('accounting::credibtors.generaledgersheet',$this->data);

        }

    }

}
