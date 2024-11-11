<?php

namespace Modules\Accounting\Entities;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Http\Controllers\Dailyrecords;

class Code extends Model
{
    private const TYPES=['revenue','expenses','accounts','credibtors'];
    private const TYPES_ENUM=['REVEN','EXPEN','ACC', 'CREDIBTOR'];

    public const breadcrumbSeperator=' / ';

    ////////////////-----------------------------////////////////

    protected $fillable =[
        'name',
        'type',
        'is_main',
        'code_id'
    ];

    public $appends = [
        'breadcrumb',
     ];
     
    ////////////////-----------------------------////////////////
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->onInsert();
        });

        static::updating(function ($model)
        {
            //throw new Exception(__('accounting::modules.accounting.exceptions.noteditable'));
        });

    }

    ////////////////-----------------------------////////////////

    public function parentCode()
    {
        return $this->belongsTo(Code::class,'code_id');
    }

    
    public function childrenCodes()
    {
        return $this->hasMany(Code::class,'code_id');
    }

    public function dailyRecordsEntries()
    {
        return $this->hasMany(DailyRecordsEntrie::class,'code_id');
    }
    
    public function deprecation()
    {
        return $this->hasOne(AssetDeprecation::class,'code_id');
    }

    public function checks()
    {
        return $this->hasMany(Check::class,'code_id');
    }

    ////////////////-----------------------------////////////////

    public static function getTypeEnum($type)
    {
        if(!in_array($type,Code::TYPES))
        {
            throw new Exception('Non Valid Type');
            die();
        }
        else
        {
            return Code::TYPES_ENUM[array_search($type,Code::TYPES)];
        }
    }

    public static function verifyType($type)
    {
        if(in_array($type,Code::TYPES))
        {
            return true;
        }

        return false;
    }

    public static function getRoutingTypeValidator()
    {
        return implode('|',Code::TYPES);
    }
    
    public static function getCodeSettingLocale($type)
    {
        $typesLocale =['revenue'=>__('accounting::modules.accounting.sidebar.codesettings_reven'),
        'expenses'=>__('accounting::modules.accounting.sidebar.codesettings_expen'),
        'accounts'=>__('accounting::modules.accounting.sidebar.codesettings_acc'),
        'credibtors'=>__('accounting::modules.accounting.credibtorCodes')];

       if(Code::verifyType($type))
        {
            return $typesLocale[$type];
        }
        
        return '';
    }

    ////////////////-----------------------------////////////////

    public function getBreadcrumbAttribute()
    {
        if(!is_null($this->parentCode))
        {
            return $this->parentCode->getBreadcrumbAttribute().Code::breadcrumbSeperator.$this->name;
        }

        return $this->name;
    }


    ////////////////-----------------------------////////////////
    public function getPeriodReport($startDate=null,$endDate=null)
    {

        $startDate=$startDate??Carbon::now()->subMonths(6)->toDateString();
        $endDate=$endDate??Carbon::now()->toDateString();

        $itemEntries=DailyRecordsEntrie::getCodeEntries($this->id,$startDate,$endDate);



        $itemEntries=array_map(
            function($elem){return is_null($elem)?0:$elem;}
            ,$itemEntries);

        return['code'=>$this->code,'breadcrumb'=>$this->breadcrumb,'report'=>$itemEntries];
    }


    ////////////////-----------------------------////////////////

    private function onInsert()
    {
        if(!is_null($this->code))
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.code.alreadyHasCode'));
        }

        //Validating parent code, level and its capacity
        if(is_null($this->code_id))
        {
            $parentCode=null;
            
        }
        else
        {
            $parentCode=$this->parentCode;
            if(is_null($parentCode))
            {
                throw new Exception(__('accounting::modules.accounting.exceptions.code.ParentNotFound'));
            }
        }

        //validating current code type
        $this->validateCodeType();

        //Validating parent code integrity
        $this->validateParentalCodeIntegrity($parentCode);

        //Validating Node capacity of children
        $this->validateParentalNodeCapcity($parentCode);
        
        //Validating name 
        $this->validateName($parentCode);
        
        //genertaing in level ID
        $this->in_level_identifier=$this->generateInlevelID($parentCode);
        
        //Setting code Level
        $this->level=is_null($parentCode)?1:$parentCode->level+1;

        //getting parental code and generating code
        $parentalCode=$this->getParentalCode($parentCode);
        $this->code=$parentalCode.$this->in_level_identifier;
        //$this->code=str_pad($parentalCode.$this->in_level_identifier,10,'0',STR_PAD_RIGHT);
    }


    ////////////////-----------------------------////////////////

    private function generateInlevelID($parentCode)
    {
        $siblings=is_null($parentCode)?Code::whereNull('code_id')->where('type','=',$this->type):$parentCode->childrenCodes;
        $siblings=$siblings->pluck('in_level_identifier')->toArray();
        $inLevelID=1;
            while(in_array($inLevelID,$siblings))
            {
                $inLevelID++;
            }

        return str_pad($inLevelID,2,'0',STR_PAD_LEFT);
    }

    private function getParentalCode($parentCode)
    {
        if(!is_null($parentCode))
        {
            return $this->getParentalCode($parentCode->parentCode).str_pad($parentCode->in_level_identifier,2,'0',STR_PAD_LEFT);
        }
        
        return '';
    }

    public static function scanForLeaves(int $rootCode)
    {
        $rootCode = Code::find($rootCode);

        if(is_null($rootCode) || $rootCode->is_main != '1')
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.nonMainCodesCannotHaveLeaves'));
        }
        else
        {
            $mainChildrenCodes=$rootCode->childrenCodes->where('is_main','1')->pluck('id')->toArray(); 
            $nonMainChildren=$rootCode->childrenCodes->where('is_main','0')->pluck('id')->toArray(); 

            while(!empty($mainChildrenCodes))
            {
                $newMainCodesScanned=[];
                foreach($mainChildrenCodes as  $code)
                {
                    $code=Code::find($code);
                    $newMainCodesScanned=array_merge($newMainCodesScanned,$code->childrenCodes->where('is_main','1')->pluck('id')->toArray());
                    $nonMainChildren=array_merge($nonMainChildren,$code->childrenCodes->where('is_main','0')->pluck('id')->toArray());
                }

                $mainChildrenCodes=$newMainCodesScanned;
            }
        
        }

        return $nonMainChildren;
    }

   
    /**
     * getCodePreiodicAmount function
     * @param  $id
     * @param  $startDate
     * @param  $endDate
     * @param  $verifiedOnly
     * @param  $paymentDate
     * @param  $credibtorType 0=>Expense 1=>Revenue (0 Default)
     */
    public static function getCodePreiodicAmount($id,$startDate,$endDate,$verifiedOnly=true,$paymentDate=false,$credibtorType=0)
    {
        $code=Code::find($id);
        if(is_null($code) || $code->is_main != '0')
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.notFoundorNonLeaf'));
        }
        else
        {
            $records=DailyRecordsEntrie::where('code_id',$id);
            
            //Distingusing between a credibtor code in a revenue and in a expenses daily record
            if($code->type=='CREDIBTOR')
            {
                $records->whereHas('dailyRecord', function($query) use ($credibtorType){
                    $query->where('type',$credibtorType?'REVEN':'EXPEN');
                    return $query;
                });
            }

            if($verifiedOnly)
            {
                   $records->whereHas('dailyRecord', function($query){
                        $query->where('financial_reviewer_assign','=',1)
                        ->where('financial_accountant_assign','=',1)
                        ->where('financial_director_assign','=',1);
                        return $query;
                    });
            }

            if($paymentDate)
            {
                if($startDate == -1)
                {
                    $records->where('payment_date','<',$endDate);
                }
                elseif($endDate == -1)
                {
                    $records->where('payment_date','>=',$startDate);
                }
                else
                {
                    $records->whereBetween('payment_date',[$startDate,$endDate]);
                }
            }
            else
            {
                $records->whereHas('dailyRecord', function($query) use ($startDate,$endDate){
                    $query->whereBetween('date',[$startDate,$endDate]);
                    return $query;
                });
            }

            $records->get();
        }

        return $records->sum('amount')??0;
    }
    

     /**
     * Calculates FTB for Credibtor Codes 
     *
     * @param $startDate 
     * @param $endDate 
     * @return array ['code breadcrumb','total-debit till date', 'total-credit till date','balance']
     */
    public function getFTB($startDate,$endDate,$verifiedOnly=true)
    {
        if($this->type != 'CREDIBTOR')
        {
            throw new Exception('Not A Credibtor Code');
            return;
        }
        
        $returnData=["name"=>$this->breadcrumb,"debtor"=>0,"creditor"=>0,"balance"=>0];

        $records=$this->dailyRecordsEntries();
            
        if($verifiedOnly)
        {
               $records->whereHas('dailyRecord', function($query){
                    $query->where('financial_reviewer_assign','=',1)
                    ->where('financial_accountant_assign','=',1)
                    ->where('financial_director_assign','=',1);
                    return $query;
                });
        }
        
        if($startDate == -1)
        {
            $records->where('payment_date','<',$endDate);
        }
        elseif($endDate == -1)
        {
            $records->where('payment_date','>=',$startDate);
        }
        else
        {
            $records->whereBetween('payment_date',[$startDate,$endDate]);
        }

        $returnData['debtor']= ((clone $records)->where('type','DEBIT')->get())->sum('amount');
        $returnData['creditor']= ((clone $records)->where('type','CREDIT')->get())->sum('amount');
        $returnData['balance']=$returnData['debtor'] - $returnData['creditor'];

        return $returnData;
    }

    /**
     * Calculates the Balance for Credibtor Codes 
     *
     * @param $startDate 
     * @param $endDate 
     * @return double|float Balance
     */
    public function getBalance($startDate,$endDate,$verifiedOnly=true)
    {
        
        

        $records=$this->dailyRecordsEntries();
            
        if($verifiedOnly)
        {
               $records->whereHas('dailyRecord', function($query){
                    $query->where('financial_reviewer_assign','=',1)
                    ->where('financial_accountant_assign','=',1)
                    ->where('financial_director_assign','=',1);
                    return $query;
                });
        }
        
        if($startDate == -1)
        {
            $records->where('payment_date','<',$endDate);
        }
        elseif($endDate == -1)
        {
            $records->where('payment_date','>=',$startDate);
        }
        else
        {
            $records->whereBetween('payment_date',[$startDate,$endDate]);
        }

        $sumDebtor= ((clone $records)->where('type','DEBIT')->get())->sum('amount');
        $sumCreditor= ((clone $records)->where('type','CREDIT')->get())->sum('amount');

        return ($sumDebtor-$sumCreditor);
    }

    public function getBalances($startDate,$endDate,$verifiedOnly=true)
    {
        $balance=0;
            //Sum leaves balance
            foreach(Code::scanForLeaves($this->id) as $leaf)
            {
                $leaf=Code::find($leaf);
                $balance+=$leaf->getBalance($startDate,$endDate,$verifiedOnly);
            }
        return $balance;
    }

    /**
     * getCodesPreiodicAmount function
     *
     * @param array $ids
     * @param [type] $startDate
     * @param [type] $endDate
     * @param [type] $verifiedOnly
     * @param [type] $paymentDate
     * @param  $credibtorType 0=>Expense 1=>Revenue (0 Default)
     * @return void
     */

    public static function getCodesPreiodicAmount(array $ids,$startDate,$endDate,$verifiedOnly,$paymentDate,$credibtorType=0)
    {
        $sum=0;
        foreach ($ids as $id)
        {
            $sum+=Code::getCodePreiodicAmount($id,$startDate,$endDate,$verifiedOnly,$paymentDate,$credibtorType);
        }
        return $sum;
    }

    public function sumDeprecation($startDate,$endDate,$verifiedOnly,$predefined=null)
    {

        $sum=0;
        if($this->type=='CREDIBTOR' && (!is_null($this->deprecation) || !is_null($predefined)))
        {
            $this->deprecation=$this->deprecation??$predefined;

            //Getting Dailyrecords entries
            $records=DailyRecordsEntrie::where('code_id',$this->id);

            $records->whereHas('dailyRecord', function($query){
                $query->where('type','=','EXPEN');
                return $query;
            });

            if($startDate==-1)
            {
                $records->where('payment_date','<',$endDate);
            }
            else
            {
                $records->whereBetween('payment_date',[$startDate,$endDate]);
            }
    
            if($verifiedOnly)
            {
                    $records->whereHas('dailyRecord', function($query){
                        $query->where('financial_reviewer_assign','=',1)
                        ->where('financial_accountant_assign','=',1)
                        ->where('financial_director_assign','=',1);
                        return $query;
                    });
            }

            $records->get();
            
            $records->each(function ($record) use (&$sum,$endDate){
                $paymentDate=Carbon::parse($record->payment_date);
                $differenceInDays= $paymentDate->diffInDays((Carbon::parse($endDate)));
                $differenceInYears=$differenceInDays/365;
                $entryDepreactionPercentage=(($differenceInYears * $this->deprecation->precentageOfDeprecation)/$this->deprecation->numberOfYears)/100;
                //return deprecated value for the record
                $sum+=($record->amount * $entryDepreactionPercentage );
            });

        }

        return $sum;
        
    }

    public function sumDeprecations($startDate,$endDate,$verifiedOnly)
    {
        $sum=0;
        foreach(self::scanForLeaves($this->id) as $leaf)
        {
            $leaf=Code::find($leaf);

            $sum+=$leaf->sumDeprecation($startDate,$endDate,$verifiedOnly,$this->deprecation);
        }
        return $sum;
    }

    public function isDeprecable()
    {
        if($this->is_main == '1')
        {
            foreach(self::scanForLeaves($this->id) as $leaf)
            {
                $leaf=Code::find($leaf);
                if(!is_null($leaf->deprecation))
                {
                    return true;
                }
            }
    
        }
        else
        {
            if(!is_null($this->deprecation))
            {
                return true;
            }
        }

        return false;
    }
    ////////////////-----------------------------////////////////

    private function validateName($parentCode,$name=null)
    {
        $name=$name??$this->name;

                $duplicate=(is_null($parentCode)?Code::whereNull('code_id')->where('type','=',$this->type):$parentCode->childrenCodes)->where('name','=',$name)->count('id');
                if($duplicate)
                {
                    throw new Exception(__('accounting::modules.accounting.exceptions.nameDuplicate'));
                }
    }

    private function validateParentalNodeCapcity($parentCode)
    {
                //Validating Node capacity of children
                $nodeCapcity=99-(is_null($parentCode)?Code::whereNull('code_id')->where('type','=',$this->type):$parentCode->childrenCodes)->count('id');
        
                if(!$nodeCapcity)
                {
                    throw new Exception(__('accounting::modules.accounting.exceptions.code.lowNodeCap'));
                }
            
    }

    private function validateParentalCodeIntegrity($parentCode)
    {
        if(!is_null($parentCode) && ( $parentCode->type != $this->type || $parentCode->is_main != '1' || $parentCode->level == 5 ) )
        {

            throw new Exception(__('accounting::modules.accounting.exceptions.code.invalidParent'));

        }         
        
        //validating that code isn't a main code in the fifth level
        if(!is_null($parentCode) && $parentCode->level == 4 && $this->is_main == '1')
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.code.cannotAddMainCode5thLevel'));
        }

    }

    private function validateCodeType()
    {
        if(!in_array($this->type,Code::TYPES_ENUM))
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.code.InvalidCodeType'));
        }
    }
}
