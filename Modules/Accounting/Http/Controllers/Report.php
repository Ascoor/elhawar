<?php

namespace Modules\Accounting\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Accounting\Entities\BudgetTerm;
use Modules\Accounting\Entities\TermItem;
use TCPDF;
use Illuminate\Support\Facades\App;
use Carbon\Carbon as carbon;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\AdminBaseController;
use Exception;
use Illuminate\Support\Facades\File;
use Modules\Accounting\Entities\AccountingSetting;
use Modules\Accounting\Entities\Code;
use Modules\Accounting\Entities\AssetDeprecation;
use Modules\Accounting\Entities\Check;
use Modules\Accounting\Entities\DailyRecordsEntrie;
use Modules\Accounting\Entities\RevenExpenCode;

class Report extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('accounting::modules.accounting.reports');
        $this->pageIcon = 'fa fa-money';
        $this->middleware(function ($request, $next) {
            if (!in_array('accounting', $this->modules)) {
                abort(403);
            }    // to be added after adding the accounting module inside the db table of working modules
            return $next($request);
        });
    }

    public function index()
    {
        $this->pageTitle = __('accounting::modules.accounting.reports');
        return view('accounting::report.index',$this->data)->with('viewData', ['pageTitle'=>__('accounting::modules.report'), 'contentHeaderTitle'=>__('accounting::modules.generateReport')]);
    }


    public function generate(Request $request)
    {
        $request->validate(
            [
                'startDate' => 'nullable|date|before_or_equal:endDate',
                'endDate' => 'nullable|date|after_or_equal:startDate',
            ]
        );

        $revenueTerms=BudgetTerm::where('type','REVEN')->get();
        $expensesTerms=BudgetTerm::where('type','EXPEN')->get();


        $includeRevenueMisc=is_null($request->input('revenueMisc'))?false:true;
        $includeExpensesMisc=is_null($request->input('expensesMisc'))?false:true;
        $includeAccountsMisc=is_null($request->input('accountsMisc'))?false:true;
        $advancedReport=is_null($request->input('advancedReport'))?false:true;


        if($includeRevenueMisc || $includeExpensesMisc || $includeAccountsMisc )
        {
            $exclude=array_merge(TermItem::pluck('code_id')->toArray());
        }

        if($includeRevenueMisc)
        {

            $revenueMisc=Code::where('type','REVEN')
            ->where('is_main','0')
            ->whereNotIN('id',$exclude)
            ->get();

            $revenMiscTerm=['name'=>__('accounting::modules.accounting.misc'),'totalCredit'=>0,'totalDept'=>0,'total'=>0,'subCodes'=>[]];

            foreach($revenueMisc as $code)
            {
                $report=$code->getPeriodReport($request);
                $revenMiscTerm['totalCredit']+=$report['report']['totalCredit'];
                $revenMiscTerm['totalDept']+=$report['report']['totalDept'];
                array_push($revenMiscTerm['subCodes'],$report);
            }

            $revenMiscTerm['total']=$revenMiscTerm['totalCredit']-$revenMiscTerm['totalDept'];

        }

        if($includeExpensesMisc)
        {
            $expensesMisc=Code::where('type','EXPEN')
            ->where('is_main','0')
            ->whereNotIN('id',$exclude)
            ->get();

            $expenMiscTerm=['name'=>__('accounting::modules.accounting.misc'),'totalCredit'=>0,'totalDept'=>0,'total'=>0,'subCodes'=>[]];

            foreach($expensesMisc as $code)
            {
                $report=$code->getPeriodReport($request);
                $expenMiscTerm['totalCredit']+=$report['report']['totalCredit'];
                $expenMiscTerm['totalDept']+=$report['report']['totalDept'];
                array_push($expenMiscTerm['subCodes'],$report);
            }

            $expenMiscTerm['total']=$expenMiscTerm['totalCredit']-$expenMiscTerm['totalDept'];

        }

        if($includeAccountsMisc)
        {
            $accountsMisc=Code::where('type','ACC')
            ->where('is_main','0')
            ->whereNotIN('id',$exclude)
            ->get();

            $accMiscTerm=['name'=>__('accounting::modules.accounting.misc'),'totalCredit'=>0,'totalDept'=>0,'total'=>0,'subCodes'=>[]];
            
            foreach($accountsMisc as $code)
            {
                $report=$code->getPeriodReport($request);
                $accMiscTerm['totalCredit']+=$report['report']['totalCredit'];
                $accMiscTerm['totalDept']+=$report['report']['totalDept'];
                array_push($accMiscTerm['subCodes'],$report);    
            }
            
            $accMiscTerm['total']=$accMiscTerm['totalCredit']-$accMiscTerm['totalDept'];
    
        }



        $revenTerms=[];
        $expenTerms=[];

        foreach($revenueTerms as $term)
        {
            array_push($revenTerms,$term->getPeriodReport($request));
        }


        foreach($expensesTerms as $term)
        {
            array_push($expenTerms,$term->getPeriodReport($request));
        }

        $data=[
            'startDate'=>$request->input('startDate')??Carbon::now()->subMonths(6)->toDateString(),
            'endDate'=>$request->input('endDate')??Carbon::now()->toDateString(),
            'revenTerms'=>$revenTerms,
            'expenTerms'=>$expenTerms,
            'expenMiscTerm'=>isset($expenMiscTerm)?$expenMiscTerm:NULL,
            'revenMiscTerm'=>isset($revenMiscTerm)?$revenMiscTerm:NULL,
            'accMiscTerm'=>isset($accMiscTerm)?$accMiscTerm:NULL,
        ];


        $documentFileName = 'Report_'.$request->input('startDate').'_'.$request->input('endDate');

        $view = $advancedReport?'accounting::report.advancedTemplate':'accounting::report.simpleTemplate';
       
       $this->printPDF(__('accounting::modules.accounting.report'),$view,$data, $documentFileName);

    }

    //Report type (0 revenexpen , 1 reciptpayment)
    public function revenExpenTwoLevels($startDate,$endDate,$paymentDate,$verified,$reportType=0)
    {
        $revenCodes=[];
        $expenCodes=[];

        if($reportType)
        {
            $revenRootMainCodes=Code::whereIN('type',['REVEN','CREDIBTOR'])->where('code_id',null)->where('is_main','1')->get();
            $revenRootNonMainCodes=Code::whereIN('type',['REVEN','CREDIBTOR'])->where('code_id',null)->where('is_main','0')->get();
            $expenRootMainCodes=Code::whereIN('type',['EXPEN','CREDIBTOR'])->where('code_id',null)->where('is_main','1')->get();
            $expenRootNonMainCodes=Code::whereIN('type',['EXPEN','CREDIBTOR'])->where('code_id',null)->where('is_main','0')->get();
            $banksMainCode=Code::where('type','CREDIBTOR')->where('code','01')->first();

        }
        else
        {
            $revenRootMainCodes=Code::where('type','=','REVEN')->where('code_id',null)->where('is_main','1')->get();
            $revenRootNonMainCodes=Code::where('type','=','REVEN')->where('code_id',null)->where('is_main','0')->get();
            $expenRootMainCodes=Code::where('type','=','EXPEN')->where('code_id',null)->where('is_main','1')->get();
            $expenRootNonMainCodes=Code::where('type','=','EXPEN')->where('code_id',null)->where('is_main','0')->get();
            $credibtorsRootMainCodes=Code::whereIN('id',RevenExpenCode::all()->pluck('code_id')->toArray())->where('is_main','1')->where('code_id',null)->get();
            $credibtorsRootNonMainCodes=Code::whereIN('id',RevenExpenCode::all()->pluck('code_id')->toArray())->where('is_main','0')->where('code_id',null)->get();    
        }

        if($reportType)
        {
            $codeData=[__('accounting::modules.accounting.bankBalancesOn')." : ".date('d-m-Y',strtotime($startDate)) ,$banksMainCode->getBalances(-1,$startDate,$verified)];
            $codeData[2]=[];

            foreach(Code::scanForLeaves($banksMainCode->id) as $code)
            {
                $code=Code::findOrFail($code);
                $codeBc=substr($code->breadcrumb,(strlen($banksMainCode->name)+strlen(Code::breadcrumbSeperator)));
                array_push($codeData[2],[$codeBc,$code->getBalance(-1,$startDate,$verified)]);
            }

            array_push($revenCodes,$codeData);
        }


        foreach($revenRootNonMainCodes as $code)
        {
            $code=Code::find($code['id']);
            array_push($revenCodes,[$code->name,Code::getCodePreiodicAmount($code->id,$startDate,$endDate,$verified,$paymentDate,1)]);
        }
        


        foreach($revenRootMainCodes as $code)
        {
            $code=Code::find($code['id']);

            if($code->type=='CREDIBTOR' && $code->code=='01' && $reportType)
            {
                continue;
            }

            $data=[$code->name,Code::getCodesPreiodicAmount(Code::scanForLeaves($code->id),$startDate,$endDate,$verified,$paymentDate,1)];
            $data[2]=[];

            $nonMainChildren=$code->childrenCodes->where('is_main','0');

            foreach($nonMainChildren as $child)
            {
                array_push($data[2],[$child->name,Code::getCodePreiodicAmount($child->id,$startDate,$endDate,$verified,$paymentDate,1)]);
            }
            unset($nonMainChildren);

            $mainChildren=$code->childrenCodes->where('is_main','1');

            foreach($mainChildren as $child)
            {
                array_push($data[2],[$child->name,Code::getCodesPreiodicAmount(Code::scanForLeaves($child->id),$startDate,$endDate,$verified,$paymentDate,1)]);
            }

            array_push($revenCodes,$data);
        }

        foreach($expenRootNonMainCodes as $code)
        {
            $code=Code::find($code['id']);
            array_push($expenCodes,[$code->name,Code::getCodePreiodicAmount($code->id,$startDate,$endDate,$verified,$paymentDate,0)]);
        }
        

        foreach($expenRootMainCodes as $code)
        {
            $code=Code::find($code['id']);

            if($code->type=='CREDIBTOR' && $code->code=='01' && $reportType)
            {
                continue;
            }

            $data=[$code->name,Code::getCodesPreiodicAmount(Code::scanForLeaves($code->id),$startDate,$endDate,$verified,$paymentDate,0)];
            $data[2]=[];

            $nonMainChildren=$code->childrenCodes->where('is_main','0');

            foreach($nonMainChildren as $child)
            {
                array_push($data[2],[$child->name,Code::getCodePreiodicAmount($child->id,$startDate,$endDate,$verified,$paymentDate,0)]);
            }
            unset($nonMainChildren);

            $mainChildren=$code->childrenCodes->where('is_main','1');

            foreach($mainChildren as $child)
            {
                array_push($data[2],[$child->name,Code::getCodesPreiodicAmount(Code::scanForLeaves($child->id),$startDate,$endDate,$verified,$paymentDate,0)]);
            }

            array_push($expenCodes,$data);
        }
        if($reportType)
        {
            $codeData=[__('accounting::modules.accounting.bankBalancesOn')." : ".date('d-m-Y',strtotime($endDate)) ,$banksMainCode->getBalances(-1,$endDate,$verified)];
            $codeData[2]=[];

            foreach(Code::scanForLeaves($banksMainCode->id) as $code)
            {
                $code=Code::findOrFail($code);
                $codeBc=substr($code->breadcrumb,(strlen($banksMainCode->name)+strlen(Code::breadcrumbSeperator)));
                array_push($codeData[2],[$codeBc,$code->getBalance(-1,$endDate,$verified)]);
            }

            array_push($expenCodes,$codeData);
        }

        if(!$reportType)
        {
            foreach($credibtorsRootNonMainCodes as $code)
            {
                $code=Code::find($code['id']);
                $code=[$code->name,Code::getCodePreiodicAmount($code->id,$startDate,$endDate,$verified,$paymentDate)];
                array_push($revenCodes,$code);
                array_push($expenCodes,$code);
            }
    
            foreach($credibtorsRootMainCodes as $code)
            {
                $code=Code::find($code['id']);
    
                $data=[$code->name,Code::getCodesPreiodicAmount(Code::scanForLeaves($code->id),$startDate,$endDate,$verified,$paymentDate)];
                $data[2]=[];
    
                $nonMainChildren=$code->childrenCodes->where('is_main','0');
    
                foreach($nonMainChildren as $child)
                {
                    array_push($data[2],[$child->name,Code::getCodePreiodicAmount($child->id,$startDate,$endDate,$verified,$paymentDate)]);
                }
                unset($nonMainChildren);
    
                $mainChildren=$code->childrenCodes->where('is_main','1');
    
                foreach($mainChildren as $child)
                {
                    array_push($data[2],[$child->name,Code::getCodesPreiodicAmount(Code::scanForLeaves($child->id),$startDate,$endDate,$verified,$paymentDate)]);
                }
    
                array_push($revenCodes,$data);
                array_push($expenCodes,$data);
            }
        }

        $totalReven=array_sum(array_column($revenCodes,1));
        $totalExpen=array_sum(array_column($expenCodes,1));

        return ["expenCodes"=>$expenCodes,'revenCodes'=>$revenCodes,'totalReven'=>$totalReven,'totalExpen'=>$totalExpen ,'total'=>($totalReven - $totalExpen)];
    }

    public function credibtorsTwoLevels($startDate,$endDate,$verified)
    {
        //Query the root codes : level 1
        $codes=Code::where('type','CREDIBTOR')->where('code_id',null)->where('code','<>','08')->orderBy('in_level_identifier', 'asc')->get();
        
        //Prepare the return data
        $codesData=[];

        //iterate throught the codes and collect data
        foreach ($codes as $code)
        {
            $codeData=[];

            $codeData["order"]=$code->in_level_identifier;
            $codeData["name"]=$code->name;
            $codeData["type"]=($code->is_main=='1')?true:false;
            $codeData["balance"]=0;

            //1:asset,0:both,liability:-1
            $codeData["location"]=0;
            //if the code is a main code get the 2nd level codes and their balances
            if($codeData["type"])
            {

                $codeData["subCodes"]=[];
                
                foreach((Code::find($code->id))->childrenCodes as $child)
                {
                    $child=Code::find($child->id);

                    if($child->is_main == '0')
                    {
                       
                        if($child->isDeprecable())
                        {
                            $codeData["subCodes"][]=[
                                'name'=>$child->name,
                                "deprecable"=>true,
                                "deprecation"=>$child->sumDeprecation(DailyRecordsEntrie::min('payment_date'),$endDate,$verified),
                                "oldBalance"=>$child->getBalance(-1,$startDate,$verified),
                                "additions"=>$child->getBalance($startDate,$endDate,$verified),
                                "balance"=>(($child->getBalance(-1,$startDate,$verified) + $child->getBalance($startDate,$endDate,$verified)) -  $child->sumDeprecation(DailyRecordsEntrie::min('payment_date'),$endDate,$verified))
                                ];
                        }
                        else
                        {
                            $balance=$child->getBalance($startDate,$endDate,$verified);
                            $codeData["subCodes"][]=['name'=>$child->name,'balance'=>$balance];
                        }
                        
                    }

                    if($child->is_main == '1')
                    {

                        //Sum leaves balance

                        if($child->isDeprecable())
                        {
                            $codeData["subCodes"][]=[
                                'name'=>$child->name,
                                "deprecable"=>true,
                                "deprecation"=>$child->sumDeprecations(DailyRecordsEntrie::min('payment_date'),$endDate,$verified),
                                "oldBalance"=>$child->getBalances(-1,$startDate,$verified),
                                "additions"=>$child->getBalances($startDate,$endDate,$verified),
                                "balance"=>(($child->getBalances(-1,$startDate,$verified) + $child->getBalances($startDate,$endDate,$verified)) -  $child->sumDeprecations(DailyRecordsEntrie::min('payment_date'),$endDate,$verified))
                                ];
                        }
                        else
                        {
                            $balance=$child->getBalances($startDate,$endDate,$verified);
                            $codeData["subCodes"][]=['name'=>$child->name,'balance'=>$balance];
                        }
                    }

                }

                //Sum all subcodes and get the abs value of balances for each subcode
                for($i=0;$i<count($codeData["subCodes"]);$i++)
                {
                    $codeData["balance"]+=$codeData["subCodes"][$i]['balance'];
                    $codeData["subCodes"][$i]['balance']=abs($codeData["subCodes"][$i]['balance']);
                }


            }
            else
            {
                $codeData["balance"]=$code->getBalance($startDate,$endDate,$verified);

                if($code->isDeprecable())
                {
                    $codeData["deprecable"]=true;
                    $codeData["deprecation"]=$code->sumDeprecation(DailyRecordsEntrie::min('payment_date'),$endDate,$verified);
                    $codeData["oldBalance"]=$code->getBalance(-1,$startDate,$verified);
                    $codeData["additions"]=$code->getBalance($startDate,$endDate,$verified);
                    $codeData["balance"]=($codeData["oldBalance"]+$codeData["additions"]) - $codeData["deprecation"] ;
                }
            }

            //1:asset,0:both,liability:-1
            $codeData["location"]=($codeData["balance"]>0)?1:(($codeData["balance"]==0)?0:-1);

            //set balance to the absloute value
            $codeData["balance"]=abs($codeData["balance"]);
            
            //Adding the code to the return data
            $codesData[]=$codeData;
        }

        
        //Filter, Sort and refine return data and calculate totals

        //Filter
        $assets = array_filter($codesData, function ($codeData) {
            return (in_array($codeData['location'], [0,1]));
        });

        $liabilities = array_filter($codesData, function ($codeData) {
            return (in_array($codeData['location'], [0,-1]));
        });

        //Free-Up Some Memory 
        unset($codesData);

        //Sort
        array_multisort(array_column($assets, 'order'), SORT_ASC, $assets);
        array_multisort(array_column($liabilities, 'order'), SORT_ASC, $liabilities);

        //Refine
            //Remove order and location columns
            foreach ($assets as &$row) {
                unset($row['order'],$row['location']);
            }
            foreach ($liabilities as &$row) {
                unset($row['order'],$row['location']);
            }

        //Append non-cashed checks to Liabilites
        $checksEntries=['name'=>'','balance'=>0, 'subCodes'=>[], 'type'=>true];
        $checks=Check::select(['code_id','date'])->selectRaw('sum(amount) as sum')->whereNotNull('code_id')->where('date','<',$endDate)->where('cashed','0')->groupBy('code_id')->pluck('sum','code_id')->toArray();

        foreach($checks as $code=>$sum)
        {
            if(is_null($sum) || empty($code))
            {
                continue;
            }
            $code=Code::findOrFail($code);
            $codeBc=substr($code->breadcrumb,(strlen(Code::where('type','CREDIBTOR')->where('code','01')->first()->name)+strlen(Code::breadcrumbSeperator)));
            $checksEntries['subCodes'][]=['name'=>__('accounting::modules.accounting.checksUnderPayment').Code::breadcrumbSeperator.$codeBc ,"balance" => $sum,"type"=>false];
            $checksEntries['balance']+=$sum;
        }
        if($checksEntries['balance']!=0)
        {
            array_unshift($liabilities, $checksEntries);
        }
        //Append capital to liabilites
        $capitalAmount=AccountingSetting::first();
        $capitalAmount=(double)$capitalAmount->capital;
        $oldRevenExpen=$this->revenExpenTwoLevels(-1,$startDate,true,$verified)['total'];
        $capital=['name'=>__('accounting::modules.accounting.capital'),'balance'=>0, 'subCodes'=>[], 'type'=>true];
        $capital['subCodes'][]=['name'=>__('accounting::modules.accounting.previousCapital'),'balance'=>$oldRevenExpen+$capitalAmount,'type'=>false];
        $revenExpen=$this->revenExpenTwoLevels($startDate,$endDate,true,$verified);
        $totalExpenses=array_sum(array_column($revenExpen['expenCodes'],1));
        $totalRevenue=array_sum(array_column($revenExpen['revenCodes'],1));
        $capital['subCodes'][]=['name'=>($totalRevenue >=  $totalExpenses)?__('accounting::modules.accounting.generalSurplus'):__('accounting::modules.accounting.generalDeficit'),'balance'=> abs($totalRevenue - $totalExpenses),'type'=>false];
        $capital['balance']=$capital['subCodes'][0]['balance']+($totalRevenue - $totalExpenses);
        array_unshift($liabilities, $capital);
        //Calculating Totals
        $totalAssets=0;
        $totalLiabilites=0;


        foreach($assets as $asset)
        {
            $totalAssets+=$asset['balance'];
        }   

        foreach($liabilities as $liability)
        {
            $totalLiabilites+=$liability['balance'];
        }   

        //Return the data
        return ["assets"=>$assets,"liabilities"=>$liabilities,"totalAssets"=>$totalAssets,"totalLiabilities"=>$totalLiabilites];
        
    }


    public function revexpenReport(Request $request)
    {
        
        if($request->isMethod('post'))
        {
            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
                ]
                );
        
            $data=$this->revenExpenTwoLevels($request->input('startDate'),$request->input('endDate'),true,false);
            $data["startDate"]=$request->input('startDate');
            $data["endDate"]=$request->input('endDate');
        
            $filename='Revenue and Expenses Report_'.$data["startDate"].'_'.$data["endDate"].'_'.date('dmYhis');

            $view ='accounting::report.revenexpenReport';

            $this->printPDF(__('accounting::modules.accounting.expenrevenReport'),$view,$data,$filename);

        }
        
        $this->pageTitle = __('accounting::modules.accounting.reports').' / '.__('accounting::modules.accounting.expenrevenReport');

        return view('accounting::layouts.dateRangePickerForm',$this->data);


    }


    public function receiptpayments(Request $request)
    {
        if($request->isMethod('post'))
        {
            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
                ]
                );


        
            $data=$this->revenExpenTwoLevels($request->input('startDate'),$request->input('endDate'),true,false,1);
            $data["startDate"]=$request->input('startDate');
            $data["endDate"]=$request->input('endDate');

            $filename='Receipt Payment Sheet_'.$data["startDate"].'_'.$data["endDate"].'_'.date('dmYhis');

            $this->printPDF(__('accounting::modules.accounting.receiptpaymentsheet'),'accounting::report.receiptpayments',$data,$filename);
        }

        $this->pageTitle = __('accounting::modules.accounting.reports').' / '.__('accounting::modules.accounting.receiptpaymentsheet');
        return view('accounting::layouts.dateRangePickerForm',$this->data);


    }


    public function trialbalance(Request $request)
    {

        if($request->isMethod('post'))
        {

            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
                ]
                );

            $startDate=(new Carbon($request->input('startDate')))->toDateString();
            $endDate=(new Carbon($request->input('endDate')))->toDateString();

            //credibtors
            $credibtors=Code::where('is_main','0')->where('type','CREDIBTOR')->get();
            $data['credibtorsDCB']=[];
            foreach($credibtors as $credibtor)
            {
                $data['credibtorsDCB'][]=$credibtor->getFTB($startDate,$endDate,false);
            }

            $data['startDate']=$startDate;
            $data['endDate']=$endDate;
            $filename='Trial Balance_'.$startDate.'_'.$endDate.'_'.date('dmYhis');

           return $this->printPDF(__('accounting::modules.accounting.trialbalance'),"accounting::report.trialbalance",$data,$filename);

        }

        $this->pageTitle =__('accounting::modules.accounting.trialbalance');
        return view('accounting::layouts.dateRangePickerForm',$this->data);

    }


    
    public function balanceSheet(Request $request)
    {

        if($request->isMethod('post'))
        {
            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
                ]
                );

            $startDate=(new Carbon($request->input('startDate')))->toDateString();
            $endDate=(new Carbon($request->input('endDate')))->toDateString();

            $data['codesData']=$this->credibtorsTwoLevels($startDate,$endDate,false);
            $data["startDate"]=$startDate;
            $data["endDate"]=$endDate;
            $filename='Balance Sheet_'.$startDate.'_'.$endDate.'_'.date('dmYhis');
            return $this->printPDF(__('accounting::modules.accounting.balanceSheet'),"accounting::report.balancesheet",$data,$filename);
        }

        $this->pageTitle = __('accounting::modules.accounting.reports').' / '.__('accounting::modules.accounting.balanceSheet');
        return view('accounting::layouts.dateRangePickerForm',$this->data);
    }

    public function depreciationSheet(Request $request)
    {

        if($request->isMethod('post'))
        {
            $request->validate(
                [
                    'startDate' => 'required|date|before_or_equal:endDate',
                    'endDate' => 'required|date|after_or_equal:startDate',
                ]
                );

            $startDate=new Carbon($request->input('startDate'));
            $endDate=new Carbon($request->input('endDate'));

            $assets=AssetDeprecation::all();
            $outputData=[];

            foreach ($assets as $asset)
            {
                $assetData=[];
                $assetData['name'] = $asset->assetCode->name;
                $assetData['balance']=($asset->assetCode->is_main)?$asset->assetCode->getBalances(-1,$startDate->toDateString(),false):$asset->assetCode->getBalance(-1,$startDate->toDateString(),false);
                $assetData['additions']=($asset->assetCode->is_main)?$asset->assetCode->getBalances($startDate->toDateString(),$endDate->toDateString(),false):$asset->assetCode->getBalance($startDate->toDateString(),$endDate->toDateString(),false);
                $assetData['totalBalance']=$assetData['balance']+$assetData['additions'];
                $assetData['deprecationPercentage']=$asset->precentageOfDeprecation;
                $assetData['previousDeprecation']=($asset->assetCode->is_main)?$asset->assetCode->sumDeprecations(-1,$startDate->toDateString(),false):$asset->assetCode->sumDeprecation(-1,$startDate->toDateString(),false);
                $assetData['wholeDeprecation']=($asset->assetCode->is_main)?$asset->assetCode->sumDeprecations(-1,$endDate->toDateString(),false):$asset->assetCode->sumDeprecation(-1,$endDate->toDateString(),false);
                $assetData['additionsDeprecation']= $assetData['wholeDeprecation'] - $assetData['previousDeprecation'];
                $assetData['totalDeprecation']= $assetData['previousDeprecation'] + $assetData['additionsDeprecation'];
                $assetData['currentValue']=$assetData['totalBalance'] - $assetData['totalDeprecation'];
                $outputData[]=$assetData;
            }


            $filename='Depreciation Sheet_'.$startDate.'_'.$endDate.'_'.date('dmYhis');
            $data['outputData']=$outputData;
            $data['startDate']=$startDate;
            $data['endDate']=$endDate;
            return $this->printPDF(__('accounting::modules.accounting.deprecationSheet'),"accounting::report.depreciationsheet",$data,$filename,'L');

        }

        $this->pageTitle = __('accounting::modules.accounting.reports').' / '.__('accounting::modules.accounting.deprecationSheet');
        return view('accounting::layouts.dateRangePickerForm',$this->data);

    }

    public function printPDF($documentTitle,$view,$data,$filename=null,$orientation='P')
    {

 
        $tcpdf_logo='@'.base64_encode(File::get(base_path() .'/public/img/tcpdf_logo.png'));
        $data['tcpdf_logo']=$tcpdf_logo;
        $filename = ($filename??'Report').'.pdf';

        if(isset($data['startDate'])){$data['startDate']=date('d-m-Y',strtotime($data['startDate']));}
        if(isset($data['endDate'])){$data['endDate']=date('d-m-Y',strtotime($data['endDate']));}
        if(isset($data['onDate'])){$data['onDate']=date('d-m-Y',strtotime($data['onDate']));}

 
        $pdf=App('TCPDF');
        $pdf->SetFont('aealarabiya', '', 12);
        $pdf->SetTitle($documentTitle);

        if (App::isLocale('ar')) {
            $pdf->setRTL(true);
        }

        $view = View::make($view,$data);
        $html_content = $view->render();


        $pdf->SetMargins(8, 8, 8, true);
        $pdf->SetFooterMargin(8);
        $pdf->SetPrintHeader(false);
        $pdf->Footer();

        $pdf->AddPage($orientation);
        $pdf->writeHTML($html_content, true, false, true, false, '');


        return $pdf->Output($filename);

    }




}