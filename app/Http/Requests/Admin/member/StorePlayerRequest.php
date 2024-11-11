<?php

namespace App\Http\Requests\Admin\member;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends CoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "name" => "required",
            "player_id" => "required",
            "national_id" => "required",
            "age"=>"required",
            "date_of_birth"=>"required",
            "country_id"=>"required",
            "city"=>"required",
            "gender"=>"required",
            "address"=>"required",
            "mobile"=>"required",
        ];

        return $rules;
    }


}
