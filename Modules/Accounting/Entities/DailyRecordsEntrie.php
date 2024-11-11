<?php

namespace Modules\Accounting\Entities;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User; //rola

class DailyRecordsEntrie extends Model
{
    protected $table = 'daily_records_entries';

    protected $fillable = [
        'daily_record_id',
        'code_id',
        'payment_date',
        'account_id',
        'amount',
        'type',
        'user_id' //rola
    ];

    public static $neutralTypes = ['ACC', 'CREDIBTOR'];

    ////////////////-----------------------------////////////////

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->onInsert();
        });


    }

    ////////////////-----------------------------////////////////

    public function dailyRecord()
    {
        return $this->belongsTo(DailyRecord::class, 'daily_record_id');
    }

    //rola
    public function userEmployee()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function code()
    {
        return $this->belongsTo(Code::class, 'code_id');
    }


    public function portions()
    {
        return $this->hasMany(DREntryPortion::class, 'entry_id');
    }

    public static function getCodeEntries($id, $startDate, $endDate, $verified = true)
    {
        $report = ['totalCredit' => 0, 'totalDept' => 0, 'total' => 0];
        $entries = DailyRecordsEntrie::where('code_id', $id)->whereHas('dailyRecord', function ($query) use ($startDate, $endDate, $verified) {
            $query->whereBetween('date', [$startDate, $endDate]);
            if ($verified) {
                $query->where('financial_reviewer_assign', '=', 1)
                    ->where('financial_accountant_assign', '=', 1)
                    ->where('financial_director_assign', '=', 1);
            }
            return $query;
        })->get();

        foreach ($entries as $entry) {
            if ($entry->type == 'DEBIT') {
                $report['totalDept'] += $entry->amount;
            } elseif ($entry->type == 'CREDIT') {
                $report['totalCredit'] += $entry->amount;
            }
        }

        $report['total'] = $report['totalCredit'] - $report['totalDept'];

        return $report;
    }



    private function onInsert()
    {

        if ($this->code->type != $this->dailyRecord->type && !in_array($this->code->type, DailyRecordsEntrie::$neutralTypes)) {
            throw new Exception(__('accounting::modules.accounting.exceptions.codeTypeMissMatch'));
        }

        if ($this->code->is_main == '1') {
            throw new Exception(__('accounting::modules.accounting.exceptions.mainCodeNotAllowed'));
        }

    }
}