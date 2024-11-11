<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreTripRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "trip_name" => "required",
            "program" => "required",
            "supervisor_id" => "required",
            "capacity" => "required|integer",
            "member_fees" => "required|numeric",
            "non_member_fees" => "required|numeric",
            "escort_fees" => "required|numeric",
            "currency" => "required",
            "start_date" => "required",
            "start_time" => "required",
            "end_date" => "required",
            "end_time" => "required",
            "repeat_every" => "integer",
            "repeat_cycles" => "integer",

        ];


        return $rules;
    }

}