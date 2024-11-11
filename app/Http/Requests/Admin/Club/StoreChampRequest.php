<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreChampRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "championship_name" => "required",
            "location_id" => "required",
            "sport_id" => "required",
            "team_id" => "required",
            "sport_type" => "required",
            "championship_type" => "required",
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