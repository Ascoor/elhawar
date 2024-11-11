<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAssessment extends Model
{
    protected $table = 'employee_assessments';
    protected $fillable =
        [
            'user_id',
            'employee_name',
            'name',
            'status',
            'opinion1',
            'opinion2',
            'opinion3',
            'date',
            'assessment_percentage',
            'extra_json',
        ];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
