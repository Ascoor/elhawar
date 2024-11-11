<?php

namespace App\Http\Requests\Admin\RentArea;

use App\Http\Requests\CoreRequest;

class StoreRentAreaRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [

            'phonenumber_id' =>"required|numeric|digits:11",
            // "fees" => "required|numeric",

            "start_date" => "required",
            "start_time" => "required",
            "end_date" => "required",
            "end_time" => "required",
            'clientname_id'=> "required|string",
            "repeat_every" => "nullable|integer",
            "repeat_cycles" => "nullable|integer",


        ];
       


        return $rules;
    }

}