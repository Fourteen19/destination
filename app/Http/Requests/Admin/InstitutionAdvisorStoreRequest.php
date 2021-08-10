<?php

namespace App\Http\Requests\Admin;

use App\Models\Institution;
use Illuminate\Foundation\Http\FormRequest;

class InstitutionAdvisorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        if ($this->getMethod() == 'POST') {

            //access the admin policy
            return auth('admin')->user()->can('create', Institution::class);

        } elseif ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $institution = $this->route('institution');

            //access the admin policy
            return auth('admin')->user()->can('update', $institution);

        }

        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'introduction.*' => 'nullable',
            'times_location.*' => 'nullable',
        ];
    }
}
