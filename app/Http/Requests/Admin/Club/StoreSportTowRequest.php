<?php

namespace App\Http\Requests\Admin\Club;

use App\Http\Requests\CoreRequest;

class StoreSportTowRequest extends CoreRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            "name" => "required",
            "code" => "required",
            "sport_kind" => "required",

        ];


        return $rules;
    }
}