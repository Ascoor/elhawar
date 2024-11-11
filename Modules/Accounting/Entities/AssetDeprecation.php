<?php

namespace Modules\Accounting\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AssetDeprecation extends Model
{

    protected $table='assets_deprecations';

    protected $fillable =
    [
        'code_id',
        'numberOfYears',
        'precentageOfDeprecation',
    ];

    //
    public function assetCode()
    {
        return $this->belongsTo(code::class,'code_id');
    }

    //
    public function dailyRecordEntries()
    {
        return $this->hasMany(DailyRecordsEntrie::class,'code_id','code_id');
    }

}
