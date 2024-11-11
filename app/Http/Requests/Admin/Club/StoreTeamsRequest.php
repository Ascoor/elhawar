<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreTeamsRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "team_name" => "required",
            "from_age" => "required|numeric",
            "to_age" => "required|numeric",
            "sport_id" => "required",
        ];


        return $rules;
    }

}