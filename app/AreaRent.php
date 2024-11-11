<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\EmployeeDetails;
use App\RentedArea;

class AreaRent extends Model
{
    protected $table = 'area_rent_details';
    protected $fillable = [
        'area_name',
        'area_capacity',
        'description',

        'location',


    ];


    // public function guardianDetials()
    // {
    //     return $this->belongsToMany(EmployeeDetails::class,'employee_details_id');
    //     // return $this->belongsToMany(EmployeeDetails::class, 'employee_details', 'employee_details_id', 'id');

    //     // 'id', 'country_id');
    //     // return $this->belongsTo(EmployeeDetails::class, 'department_id');
    // }

    public function rentedArea()
    {
        return $this->hasMany(RentedArea::class,'area_rent_details','id'); 

    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}