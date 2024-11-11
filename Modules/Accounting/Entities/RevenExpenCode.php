<?php
namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;

class RevenExpenCode extends Model
{

    protected $table = 'reven_expen_credibtors_terms';

    protected $fillable =
    [
        'code_id'
    ];
    
    public function code()
    {
        return $this->belongsTO(Code::class,'code_id');
    }

}
