<?php

namespace App\Http\Requests\Admin\Player;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
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
            "union_id" => "required",
            "national_id" => "required",
            "national_id" => "required",
            "age"=>"required",
            "date_of_birth"=>"required",
            "country_id"=>"required",
            "city"=>"required",
            "state"=>"required",
            "address"=>"required",
            "mobile"=>"required",
        ];

        return $rules;
    }
}
