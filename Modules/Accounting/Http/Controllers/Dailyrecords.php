<?php

namespace Modules\Accounting\Http\Controllers;
use Modules\Accounting\Entities\Code;
use Illuminate\Http\Request;
use Modules\Accounting\Entities\DailyRecord;

use Modules\Accounting\Entities\DailyRecordsEntrie;
use Exception;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;
use TCPDF;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Admin\AdminBaseController;
use Carbon\Carbon;

class Dailyrecords extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('accounting::modules.accounting.accounting');
        $this->pageIcon = 'fa fa-money';
        $this->middleware(function ($request, $next) {
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index($type, Request $request)
    {
        $pName= __('accounting::modules.accounting.accounting').': '.__('accounting::modules.accounting.sidebar.dailyrecord');
        if($type=='expenses'){
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.sidebar.dailyrecord_expen');
        }else{
            $this->pageTitle = $pName.' / '.__('accounting::modules.accounting.sidebar.dailyrecord_reven');
        }

        if ($request->ajax()) {

            
            $query = DailyRecord::where('type', ($type=='revenue')?'REVEN':'EXPEN');
            return DataTables::of($query)->make(true);
   
        }

        $viewData=['pageTitle'=>__('accounting::modules.accounting.dailyrecords').' | '.ucfirst(__('accounting::modules.accounting.'.$type)),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.accounting.dailyrecords')).' - '.ucfirst(__('accounting::modules.accounting.'.$type))];
        $viewData['type']=$type;


        return view('accounting::dailyrecords.index',$this->data)->with('viewData', $viewData);
    }


    public function destroy($type, $id='notdefinied' )
    {
        //$id = 'notdefinied'


        $code = DailyRecord::findOrFail($id);
        $code->delete();

        return redirect(route('admin.accounting.dailyrecords.index', $type))
        ->with('success', __('accounting::modules.accounting.deleteSuccess'));
    }

    public function print($id='notdefinied')
    {
        $record=DailyRecord::findOrFail($id);
        $documentFileName = 'DailyRecord_'.$record['type']=='REVEN'?'Revenue':'Expenses'.'_'.$record['date'].'.pdf';

        $view = View::make('accounting::dailyrecords.invoice',['record'=>$record,'type'=>$record['type']=='REVEN'?__('accounting::modules.accounting.revenue'):__('accounting::modules.accounting.expenses')]);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aefurat', '', 10);
        
        if (App::isLocale('ar')) {
            $pdf->setRTL(true);
        }
        
        $pdf->SetTitle('Daily '.$record['type']=='REVEN'?'Revenue':'Expenses'.' Record Report - '.$record['date']);
        $pdf->AddPage('P', 'A4');
        $pdf->writeHTML($html_content, true, false, true, false, '');
        return $pdf->Output($documentFileName);
    }

    public function create($type)
    {

        if($type=='expenses'){
            $drTypeName = __('accounting::modules.accounting.sidebar.dailyrecord_expen');
         }else{
             $drTypeName =__('accounting::modules.accounting.sidebar.dailyrecord_reven');
         }

        $this->pageTitle = __('accounting::modules.accounting.accounting').' : '.__('accounting::modules.accounting.sidebar.dailyrecord')
        . ' / '. $drTypeName. ' / '.__('accounting::modules.accounting.sidebar.add_daily');
        $viewData=['pageTitle'=>__('accounting::modules.accounting.dailyrecords').' | '.__('accounting::modules.accounting.add'),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.accounting.dailyrecords')).' - '.__('accounting::modules.accounting.add')];
        $viewData['type']=$type;


        return view('accounting::dailyrecords.create',$this->data)->with('viewData', $viewData);
    }

    public function store(Request $request,$type)
    {


        $request->validate(
            [
                'date'=>'required|date|before_or_equal:today',
                'debitCodes'=>'required|array',
                'debitCodes.*'=>'exists:Modules\Accounting\Entities\Code,id',
                'creditorCodes'=>'required|array',
                'creditorCodes.*'=>'exists:Modules\Accounting\Entities\Code,id',
                'debitAmounts'=>'required|array',
                'debitAmounts.*'=>'numeric',
                'creditorAmounts'=>'required|array',
                'creditorAmounts.*'=>'numeric',
                'debitDates'=>'required|array',
                'creditorDates'=>'required|array',

            ]
            );


            try
            {
                $record=DailyRecord::create([
                    'date'=>$request->input('date'),
                    'type' => ($type=='revenue')?'REVEN':'EXPEN',
                    'description'=>$request->input('description')
                ]);

                for ($i=0;$i<count($request->input('debitCodes'));$i++)
                {
                    DailyRecordsEntrie::create(
                        [
                            'daily_record_id'=>$record['id'],
                            'code_id'=>$request->input('debitCodes')[$i],
                            'amount'=>$request->input('debitAmounts')[$i],
                            'payment_date'=>($request->input('debitDates')[$i]!=-1)?$request->input('debitDates')[$i]:$request->input('date'),
                            'type'=>'DEBIT',
                            //rola
                            'user_id'=>$request->input('created_rec_employee_id') 
                        ]);
                }

                for ($i=0;$i<count($request->input('creditorCodes'));$i++)
                {
                    DailyRecordsEntrie::create(
                        [
                            'daily_record_id'=>$record['id'],
                            'code_id'=>$request->input('creditorCodes')[$i],
                            'amount'=>$request->input('creditorAmounts')[$i],
                            'payment_date'=>($request->input('creditorDates')[$i]!=-1)?$request->input('creditorDates')[$i]:$request->input('date'),
                            'type'=>'CREDIT',
                            //rola
                            'user_id'=>$request->input('created_rec_employee_id')
                        ]);
                }

            }
            catch(Exception $e)
            {
                throw ValidationException::withMessages([__('accounting::modules.accounting.codesettingsUnexcepectedError').$e->getMessage()]);
            }
    

            return redirect(route('admin.accounting.dailyrecords.index', $type))
            ->with('success', __('accounting::modules.accounting.storesuccess'));
    }


    public function edit($type,$id=null)
    {
        $record=DailyRecord::findOrFail($id);

        if($type=='expenses'){
           $drTypeName = __('accounting::modules.accounting.sidebar.dailyrecord_expen');
        }else{
            $drTypeName =__('accounting::modules.accounting.sidebar.dailyrecord_reven');
        }

        $this->pageTitle=__('accounting::modules.accounting.dailyrecords').' / '. $drTypeName .' / '.__('accounting::modules.accounting.edit');
        
        $viewData=['pageTitle'=>__('accounting::modules.accounting.dailyrecords').' | '. $drTypeName .' | '.__('accounting::modules.accounting.edit'),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.accounting.dailyrecords')).' - '.__('accounting::modules.accounting.edit')];
        $viewData['type']=$type;

        return View('accounting::dailyrecords.edit',['viewData'=>$viewData,'record'=>$record],$this->data);
    }

    public function preview($id=null)
    {
        $record=DailyRecord::findOrFail($id);

        $viewData=['pageTitle'=>__('accounting::modules.accounting.dailyrecords').' | '.__('accounting::modules.accounting.preview'),
        'contentHeaderTitle'=>ucfirst(__('accounting::modules.accounting.dailyrecords')).' - '.__('accounting::modules.accounting.preview')];

        $viewData['type']=$record->type;
        return View('accounting::dailyrecords.preview',['viewData'=>$viewData,'record'=>$record],$this->data);
    }


    public function update($type,$id,Request $request)
    {

        $record=DailyRecord::findOrFail($id);

        $request->validate(
            [
                'oldDebitEntries.*'=>'exists:Modules\Accounting\Entities\DailyRecordsEntrie,id',
                'oldCreditorEntries.*'=>'exists:Modules\Accounting\Entities\DailyRecordsEntrie,id',

                'oldCreditorAmounts'=>'required_with:oldCreditorEntries|array',
                'oldCreditorAmounts.*'=>'numeric',

                'oldDebitAmounts'=>'required_with:oldDebitEntries|array',
                'oldDebitAmounts.*'=>'numeric',

                'debitCodes'=>'required_without:oldDebitEntries|array',
                'debitCodes.*'=>'exists:Modules\Accounting\Entities\Code,id',

                'creditorCodes'=>'required_without:oldCreditorEntries|array',
                'creditorCodes.*'=>'exists:Modules\Accounting\Entities\Code,id',

                'debitAmounts'=>'required_with:debitCodes|array',
                'debitAmounts.*'=>'numeric',

                'creditorAmounts'=>'required_with:creditorCodes|array',
                'creditorAmounts.*'=>'numeric',

                'oldDebitDates'=>'required|array',
                'oldCreditorDates'=>'required|array',

            ]
            );

            //updating description
            $record->description=$request->input('description');
            $record->save();

            $oRecordsInput = array_merge($request->input('oldDebitEntries')??[], $request->input('oldCreditorEntries')??[]);
            $oAmounts = array_merge($request->input('oldDebitAmounts')??[], $request->input('oldCreditorAmounts')??[]);
            $oDates = array_merge($request->input('oldDebitDates')??[], $request->input('oldCreditorDates')??[]);

         //updating old entries

            try

            {


                //deleting non-existing records
                DailyRecordsEntrie::whereNotIn('id',$oRecordsInput)->where('daily_record_id','=',$record->id)->delete();

                if(!empty($oRecordsInput))
                {
                    //handling old records
                    $oldRecords=DailyRecordsEntrie::whereIn('id', $oRecordsInput)->where('daily_record_id','=',$record->id)->get();

                    $i=0;

                    foreach($oldRecords as $oRecord)
                    {
                        $oRecord->amount=$oAmounts[$i];
                        $oRecord->payment_date=$oDates[$i];

                        $oRecord->save();
                        $i++;
                    }
                }
            }
            catch (Exception $e)
            {
                throw ValidationException::withMessages([__('accounting::modules.accounting.codesettingsUnexcepectedError')]);
            }


            //handling New entries


            //handling new records
            if(!empty($request->input('debitCodes')))
            {

                try
                {

                    for ($i=0;$i<count($request->input('debitCodes'));$i++)
                    {
                        DailyRecordsEntrie::create(
                            [
                                'daily_record_id'=>$record->id,
                                'code_id'=>$request->input('debitCodes')[$i],
                                'amount'=>$request->input('debitAmounts')[$i],
                                'payment_date'=>($request->input('debitDates')[$i]!=-1)?$request->input('debitDates')[$i]:$request->input('date'),
                                'type'=>'DEBIT',
                            ]);
                    }
                    }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.codesettingsUnexcepectedError')]);
                }

            }
            if(!empty($request->input('creditorCodes')))
            {

                try
                {

                    for ($i=0;$i<count($request->input('creditorCodes'));$i++)
                    {
                        DailyRecordsEntrie::create(
                            [
                                'daily_record_id'=>$record->id,
                                'code_id'=>$request->input('creditorCodes')[$i],
                                'amount'=>$request->input('creditorAmounts')[$i],
                                'payment_date'=>($request->input('creditorDates')[$i]!=-1)?$request->input('creditorDates')[$i]:$request->input('date'),
                                'type'=>'CREDIT',
                            ]);
                    }
                    }
                catch(Exception $e)
                {
                    throw ValidationException::withMessages([__('accounting::modules.accounting.codesettingsUnexcepectedError')]);
                }

            }


            return redirect(route('admin.accounting.dailyrecords.edit', [$type,$id]))
            ->with('success', __('accounting::modules.accounting.editsuccess'));

    }

    public function periodicreport($type,Request $request)
    {
        $request->validate(
            [
                'startDate' => 'required|date|before_or_equal:endDate',
                'endDate' => 'required|date|after_or_equal:startDate',

            ]
            );

        $startDate=(new Carbon($request->input('startDate')))->toDateString();
        $endDate=(new Carbon($request->input('endDate')))->toDateString();

        $records=DailyRecord::whereBetween('date',[$startDate,$endDate])
                                   /* ->where('financial_reviewer_assign','=',1)
                                    ->where('financial_accountant_assign','=',1)
                                    ->where('financial_director_assign','=',1)
                                    ->orderBy('date','ASC')*/
                                    ->get();

        $documentFileName = 'DailyRecords_'.$type.'_'.$startDate.'-'.$endDate.'.pdf';

        $view = View::make('accounting::dailyrecords.periodicreport',['records'=>$records,'startDate'=>$startDate,'endDate'=>$endDate,'type'=>($type=='revenue')?__('accounting::modules.accounting.revenue'):__('accounting::modules.accounting.expenses'),'rType'=>$type]);
        $html_content = $view->render();
        $pdf=App('TCPDF');
        $pdf->SetFont('aefurat', '', 10);
        
        if (App::isLocale('ar')) {
            $pdf->setRTL(true);
        }
        
        $pdf->SetTitle('DailyRecords_'.$type.'_'.$startDate.'-'.$endDate);
        $pdf->AddPage('P', 'A4');
        $pdf->writeHTML($html_content, true, false, true, false, '');
        return $pdf->Output($documentFileName);

    }

    public function ajax(Request $request,$type,$operation)
    {


        switch($operation)
        {
            case 'selCode':
                try
                {
                    $records = Code::whereIN('type',explode(',',$request->input('type')) )
                    ->where('is_main','=','0')
                    ->where(function($query) use ($request){
                        return $query->where('name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('code', 'like', '%' . $request->input('search') . '%');
                    })
                    ->limit(50)
                    ->get()
                    ->sortBy("breadcrumb");
    
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                }
                $response = [];
                foreach($records as $record){
                   $response[] = 
                   [
                        "id"=>($record->id),
                        "text"=> $record->code.' - '.$record->breadcrumb,
                   ];
                }


                return response()->json($response);

            break;

            case 'selCodeAll':
                try
                {
                    $records = Code::whereIN('type',explode(',',$request->input('type')) )
                    ->where(function($query) use ($request){
                        return $query->where('name', 'like', '%' . $request->input('search') . '%')
                        ->orWhere('code', 'like', '%' . $request->input('search') . '%');
                    })
                    ->limit(50)
                    ->get()
                    ->sortBy("breadcrumb");
    
                }
                catch(Exception $e)
                {
                    echo $e->getMessage();
                }
                $response = [];
                foreach($records as $record){
                   $response[] = 
                   [
                        "id"=>($record->id),
                        "text"=> $record->code.' - '.$record->breadcrumb,
                   ];
                }


                return response()->json($response);

            break;

            default:
                abort(404);
            break;

        }
    }
}
