<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AreaRent;
use App\EmployeeDetails;

class RentedArea extends Model
{
   
                protected $table = 'rented_area';
                protected $fillable = [
                    // 'total_price',
                    'start_date_time',
                    'end_date_time',
                    'area_rent_details_id',
                    'status',
                    'guardian',
                    'price',
                    'client_name',
                    'phone_number',

                    // 'start_date',
                    // 'end_date',
                    'session_repeat',
                    'employee_details_id',
                    'repeat_type',
                    'label_color',
                    'repeat_every',
                    'repeat_cycles',


        
                   
                 
                ];


                public function guardianDetials()
                {
                    return $this->belongsTo(EmployeeDetails::class,'employee_details_id','id');
                    // return $this->belongsToMany(EmployeeDetails::class, 'employee_details', 'employee_details_id', 'id');
            
                    // 'id', 'country_id');
                    // return $this->belongsTo(EmployeeDetails::class, 'department_id');
                }

                public function rentAreaDetails(){
                    return $this->belongsTo(AreaRent::class,'area_rent_details_id','id'); 
                }


}
