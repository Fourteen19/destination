<?php

namespace App\Http\Requests\Frontend;

use App\Models\SystemTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class SelfAssessmentMyPreferences extends FormRequest
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

        $validationRules['routes'] = 'required';

        $tags = SystemTag::where('type', 'route')->where('live', 'Y')->select('name')->get();
        foreach($tags as $item)
        {
            $validationRules['routes.'.$item->name] = "in:".$item->name."";
        }


        $validationRules['sectors'] = 'required';

        $tags = SystemTag::where('type', 'route')->where('live', 'Y')->select('name')->get();
        foreach($tags as $item)
        {
            $validationRules['sectors.'.$item->name] = "in:".$item->name."";
        }


        $tags = SystemTag::where('type', 'subject')->where('live', 'Y')->select('name')->get();
        foreach($tags as $key => $item)
        {
            $validationRules['subjects.'.$item->name] = 'required|in:"I like it", "I dont mind it", "Not for me", "Not applicable"';

        }
        $validationRules['subjects'] = "SelfAssessmentCheckAtLeastOneIsSubjectIsSelected";



        return $validationRules;

    }


    public function messages()
    {

        $messages = [];

        //routes
        $messages['routes.required'] = 'Please select at least one route';
        $messages['routes.in'] = 'Please select at least one route';

        $tags = SystemTag::where('type', 'route')->where('live', 'Y')->select('name')->get();
        foreach($tags as $item)
        {
            $messages['routes.'.$item->name.'.in'] = "Invalid value for ".$item->name;
        }

        //subjects
        $tags = SystemTag::where('type', 'subject')->where('live', 'Y')->select('name')->get();
        foreach($tags as $key => $item)
        {
            $validationMessages['subjects.'.$item->name.'.required'] = 'Please give a rating to the following subject:'.$item->name;
            $validationMessages['subjects.'.$item->name.'.in'] = 'Invalid value for subject '.$item->name;
        }
        $messages['subjects.self_assessment_check_at_least_one_is_subject_is_selected'] = 'Please select a minimum of one subject that you like or do not mind';


        //sectors
        $messages['sectors.required'] = 'Please select at least one sector';
        $messages['sectors.in'] = 'Please select at least one sector';

        $tags = SystemTag::where('type', 'sector')->where('live', 'Y')->select('name')->get();
        foreach($tags as $item)
        {
            $messages['sectors.'.$item->name.'.in'] = "Invalid value for ".$item->name;
        }


        return $messages;

    }

}
