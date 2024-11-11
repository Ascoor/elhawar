<?php

namespace App\Http\Requests\Admin\member;

use App\Http\Requests\CoreRequest;
use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Rule;


class StoreMembertRequest extends CoreRequest
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
        // Validator::validate($input, [
        //     'attachment' => [
        //         'required',
        //         File::types(['mp3', 'wav'])
        //             ->min(1024)
        //             ->max(12 * 1024),
        //     ],
        // ]);

        $rules = [
            "name" => "required|string",
            "password" => "required|min:6",
            // "email" => "required|email",
            "email" => "required|email|unique:member_details,email",
            // |email|unique:users

            // 'slack_username' => 'nullable|unique:employee_details,slack_username',
           // 'website' => 'nullable',
//            'facebook' => 'nullable|regex:/http(s)?://\/(www\.)?(facebook|fb)\.com\/(A-z 0-9)?/',
//            'twitter' => 'nullable|regex:/http(s)?://(.*\.)?twitter\.com\/[A-z 0-9 _]+\/?/',
//            'linkedin' => 'nullable|regex:/((http(s?)://)*([www])*\.|[linkedin])[linkedin/~\-]+\.[a-zA-Z0-9/~\-_,&=\?\.;]+[^\.,\s<]/',

//rola added numeric to "member_id"
//rola added numeric to "age"
            "member_id" => "required|unique:member_details,member_id|numeric",
            "family_id" => "required",
            // "name"=>"required",
            "national_id"=>"required|unique:member_details,national_id|numeric|digits:14",
            "age"=>"required|numeric",
            
            "date_of_birth"=>"required",
            "date_of_subscription"=>"required",
            'date_of_last_payment' =>"required", //rola added it, cant be empty


            "profession"=>"required|string", //|exists:member_details,profession

            // "religion"=>"required", comented it because its select list
            "city"=>"required|string",
            "state"=>"required|string",
            "country_id"=>"required",
            'postalCode'=>'nullable|numeric',  //rola added it, can be empty but if not then it must be numeric
           
            // 'last_paid_fiscal_year'=>'nullable|',  //rola added it, can be empty but if not then it must be numeric
            // 'date_of_the_board_of_directors'=>'nullable|',  //rola added it, can be empty but if not then it must be numeric
            // 'decision_number'=>'nullable|',  //rola added it, can be empty but if not then it must be numeric
            
            'mem_GraduationDesc'=>'nullable|string', //rola add text only //|exists:member_details,mem_GraduationDesc

            'mem_HomePhone'=>'nullable|numeric', //can accept + only
            'mem_WorkPhone'=>'nullable|numeric',
            // |^\+[0-9]+$|\d{1,5}\+\d{1,2}(?:\.\d)
            'memCard_MemberName'=>'nullable|string',//|exists:member_details,memCard_MemberName
            // 'image' => 'nullable|mimes:jpeg,jpg,png|max:3000',
            //  'image' => 'nullable|image',
            //  'image' => 'nullable|File::image()->min(1024)->max(12 * 1024)->dimensions(\TijsVerkoyen\CssToInlineStyles\Css\Rule\Rule::dimensions()->maxWidth(1000)->maxHeight(500))',
            // 'image' => 'nullable|image|mimes:jpg,png,jpeg|max:3000|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
            'image' =>  'nullable|image|mimes:jpg,png,jpeg|max:3000', //|min:1 1kilobyte
            "address"=>"required",
            "mobile"=>"required|min:10", //|max:13
            'note'=>'nullable|max:2000',
            'note_2'=>'nullable|max:2000',
            'note_3'=>'nullable|max:2000',
            'note_4'=>'nullable|max:2000',
            'remarks'=>'nullable|max:2000',

            
        ];

        return $rules;
    }


}
