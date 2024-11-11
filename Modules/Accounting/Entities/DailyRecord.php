<?php

namespace Modules\Accounting\Entities;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Accounting\Notifications\newDailyRecord;
use App\User;
use Modules\Accounting\Entities\DailyRecordsEntrie;
use Illuminate\Validation\ValidationException;

class DailyRecord extends Model
{
    protected $table = 'daily_records';


    protected $fillable = [
        'date',
        'type',
        'description',

        //rola
        'recordIdentifier',
        'financial_reviewer_assign',
        'financial_accountant_assign',
        'financial_director_assign',
        'status',
    ];

    public $appends = [
        'journalEntryNo',
        'excerpt',
        'dept',
        'credit',
        'total',
        'recordCreatedBy',
    ];

    ////////////////-----------------------------////////////////

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->onInsert();

            //Sending notification
            $users = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.*')
                // ->where('roles.name', 'financialReviewer')
                // ->where('roles.name', 'admin')
                ->where('roles.name', 'financialReviewer')
                ->get();
            foreach ($users as $user) {
                $user->notify(new newDailyRecord((object) ['date' => $model->date, 'journalEntryNo' => $model->journalEntryNo, 'type' => (($model->type == 'EXPEN') ? 'expenses' : 'revenue')]));
            }

        });


    }

    ////////////////-----------------------------////////////////


    public function entries()
    {
        return $this->hasMany(DailyRecordsEntrie::class, 'daily_record_id', 'id');
    }

    public function getExcerptAttribute()
    {
        return Str::words($this->description, 10, '...');

    }

    public function getJournalEntryNoAttribute()
    {
        return str_pad($this->recordIdentifier, 3, '0', STR_PAD_LEFT) . '/' . str_pad(date('m', strtotime($this->date)), 2, '0', STR_PAD_LEFT) . '/' . str_pad(date('y', strtotime($this->date)), 2, '0', STR_PAD_LEFT) . '/' . (($this->type == 'EXPEN') ? __('accounting::modules.accounting.dailyRecordsE') : __('accounting::modules.accounting.dailyRecordsR'));
    }

    public function getDeptAttribute()
    {
        return $this->sumEntriesAmountOfType('DEBIT');

    }

    public function getCreditAttribute()
    {
        return $this->sumEntriesAmountOfType('CREDIT');
    }

    public function getTotalAttribute()
    {
        return number_format((float) $this->dept - $this->credit, 2, '.', null);
    }

    private function sumEntriesAmountOfType($type)
    {
        $amount = 0;
        foreach (is_null($type) ? $this->entries : $this->entries->where('type', '=', $type) as $entry) {
            $amount += $entry->amount;
        }
        return $amount;

    }

    public function position()
    {
        return $this->entries->belongsTo(User::class, 'user_id', 'id');
    }

    //rola
    public function getrecordCreatedByAttribute()
    {
        //      $id=$this->position;
        // foreach (is_null('user_id')?$this->entries:$this->entries->where('user_id','=', $id) as $entry)
        // {
        //     return $entry->user_id;
        // }

        foreach ($this->entries as $enter) {
            return 'ID: ' . $enter->user_id . ', Name:' . $enter->userEmployee->name;
            // return   [$enter->user . ' ' .$enter->userEmployee->name];

        }
        // return $this->entries;
        // return $this->entries->user_id;
    }

    //     public function getrecordCreatedByAttribute(){
    //         $users =User::all('*');
    //         // $amount=0;


    //         foreach($users as $user ){
    //         $daily_records_entriy =DailyRecordsEntrie::where('user_id','=', $user->id);

    //         // foreach (is_null('user_id')?$this->entries:$this->entries->where('user_id','=', $user) as $entry)
    //         // {
    //         //     $amount=$entry->user_id;
    //          return $user->name; 

    //         //     // $this->recordCreatedBy=$amount;
    //         // }
    //         //  return $daily_records_entriy->user_id; 
    //         }
    //         // return $user->name; 
    //         // return $amount; 


    // // return $this->value;
    //     }



    // public function setrecordCreatedByAttribute($id)
    // {
    //     $amount=0;
    //         foreach (is_null('user_id')?$this->entries:$this->entries->where('user_id','=',$id) as $entry)
    //         {
    //             $amount=$entry->user_id;
    //             // $this->recordCreatedBy=$amount;
    //         }
    //     $this->attributes['recordCreatedBy'] = $amount;
    // }
    // public function getrecordCreatedByAttribute()
    // {
    //     return "{$this->recordCreatedBy}";
    // }

    //rola 
    // public function getrecordCreatedByAttribute($id){

    //     $amount=0;
    //     foreach (is_null('user_id')?$this->entries:$this->entries->where('user_id','=',$id) as $entry)
    //     {
    //         $amount=$entry->user_id;
    //         $this->recordCreatedBy=$amount;
    //     }
    // //    return $this->recordCreatedBy;
    //     return $amount;
    // }


    private function onInsert()
    {
        //Setting status to pending at insert 
        $this->status = 'Pending';

        if (strtotime($this->date) > strtotime(Carbon::now()->toDateString())) {
            throw new Exception(__('accounting::modules.accounting.exceptions.futuristicDate'));
        }

        //Generating daily record identifier
        $carbonDate = new Carbon($this->date);
        $lastEntry = DailyRecord::whereBetween('date', [$carbonDate->startOfMonth()->toDateString(), $carbonDate->endOfMonth()->toDateString()])->where('type', $this->type);

        if ($lastEntry->count() >= 999) {
            throw new Exception(__('accounting::modules.accounting.exceptions.entriesExceedsTheLimit'));
        } else {
            $lastEntry = $lastEntry->count();
        }

        $this->recordIdentifier = $lastEntry + 1;


    }


}