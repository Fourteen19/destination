<?php

namespace App\Http\Requests\Frontend;

use App\Models\SystemTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SelfAssessmentSectors extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::guard('web')->check())
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

        $validationRules['submit'] = 'required';
        $validationRules['sectors'] = 'required';

        $tags = SystemTag::where('type', 'route')->where('live', 'Y')->select('name')->get();
        foreach($tags as $item)
        {
            $validationRules['sectors.'.$item->name] = "in:".$item->name."";
        }

        return $validationRules;

    }


    public function messages()
    {

        $messages = [];
        $messages['sectors.required'] = 'Please select at least one option';
        $messages['sectors.in'] = 'Please select at least one option';

        $tags = SystemTag::where('type', 'sector')->where('live', 'Y')->select('name')->get();
        foreach($tags as $item)
        {
            $messages['sectors.'.$item->name.'.in'] = "Invalid value for ".$item->name;
        }

        return $messages;
    }

}
