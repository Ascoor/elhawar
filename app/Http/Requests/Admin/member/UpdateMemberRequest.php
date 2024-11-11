<?php

namespace App\Http\Requests\Admin\member;

use App\Http\Requests\CoreRequest;

class UpdateMemberRequest extends CoreRequest
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
            "password" => "required",
            "email" => "required|email",
            // 'slack_username' => 'nullable|unique:employee_details,slack_username',
            // 'website' => 'nullable',
//            'facebook' => 'nullable|regex:/http(s)?://\/(www\.)?(facebook|fb)\.com\/(A-z 0-9)?/',
//            'twitter' => 'nullable|regex:/http(s)?://(.*\.)?twitter\.com\/[A-z 0-9 _]+\/?/',
//            'linkedin' => 'nullable|regex:/((http(s?)://)*([www])*\.|[linkedin])[linkedin/~\-]+\.[a-zA-Z0-9/~\-_,&=\?\.;]+[^\.,\s<]/',

//            "member_id" => "required|unique:member_details,member_id",
            "family_id" => "required",
            "age"=>"required",
            "date_of_birth"=>"required",
            "profession"=>"required",
            "religion"=>"required",
            "city"=>"required",
            "state"=>"required",
            "country_id"=>"required",
            "address"=>"required",
            "mobile"=>"required",
//            "phone_code"=>"required",
            //"national_id"=>"required|numeric|digits:14|unique:member_details,national_id". $this->request->get('id'),
        ];

        return $rules;
    }

}