<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreSportActivityRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "session_name" => "required",
            "session_id" => "required",
            "reservation_type" => "required",
            "location_id" => "required",
            "sport_id" => "required",
            "level_id" => "required",
            "group_id" => "required",
            "coach_id" => "required",
            "capacity" => "required|integer",
            "fees" => "required|numeric",
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