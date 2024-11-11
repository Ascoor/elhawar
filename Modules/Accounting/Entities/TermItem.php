<?php

namespace Modules\Accounting\Entities;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Modules\Accounting\Entities\BudgetTerm;

class TermItem extends Model
{
    protected $table='term_items';

    protected $fillable =
    [
        'code_id',
        'budget_term_id'
    ];

    ////////////////-----------------------------////////////////
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model)
        {
            $model->onInsert();
        });


    }

    ////////////////-----------------------------////////////////

    public function code()
    {
        return $this->belongsTO(Code::class,'code_id');
    }

    public function term()
    {
        return $this->belongsTO(BudgetTerm::class);
    }


    private function onInsert()
    {
        
        if($this->code->type!=$this->term->type && $this->code->type != 'ACC')
        {
            throw new Exception(__('accounting::modules.accounting.exceptions.codeTypeMissMatch'));
        }

    }

}
