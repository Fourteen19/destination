<?php

namespace App\Http\Requests\Frontend;

use App\Models\SystemTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SelfAssessmentSubjects extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check())
        {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $validationRules = [];

        $validationRules['submit'] = 'required';

        $tags = SystemTag::where('type', 'subject')->where('live', 'Y')->select('name')->get();
        foreach($tags as $key => $item)
        {
            $validationRules['subjects.'.$item->name] = 'required|in:"I like it", "I dont mind it", "Not for me", "Not applicable"';

        }

        return $validationRules;

    }




    public function messages()
    {

        $validationMessages = [];

        $tags = SystemTag::where('type', 'subject')->where('live', 'Y')->select('name')->get();
        foreach($tags as $key => $item)
        {
            $validationMessages['subjects.'.$item->name.'.required'] = 'Please give a rating to '.$item->name;
            $validationMessages['subjects.'.$item->name.'.in'] = 'Invalid value for '.$item->name;
        }

        return $validationMessages;




    }

}
