<?php

namespace Modules\Accounting\Entities;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\TermItem;
use Illuminate\Http\Request;

class BudgetTerm extends Model
{
    protected $table='budget_terms';

    protected $fillable =
    [
        'name',
        'type'
    ];

    public function validate(Request $request)
    {
        $request->validate(
            [
                'name'=>'required|max:120|unique:Modules\Accounting\Entities\BudgetTerm,name,'.$this->id.',id,type,'.$this->type
            ]
            );
    }
    public function items()
    {
        return $this->hasMany(TermItem::class);
    }

    public function setName($name)
    {
        $this->attributes['name']=$name;
    }


    public function getPeriodReport($startDate,$endDate)
    {
        $subCodes=[];

        $totalCredit=0;
        $totalDept=0;

        foreach($this->items as $item)
        {
            $report=$item->code->getPeriodReport($startDate,$endDate);
            $totalCredit+=$report['report']['totalCredit'];
            $totalDept+=$report['report']['totalDept'];
            array_push($subCodes,$report);
        }

        return ['name'=>$this['name'],'totalCredit'=>$totalCredit,'totalDept'=>$totalDept,'total'=>$totalCredit-$totalDept,'subCodes'=>$subCodes];

    }

}
