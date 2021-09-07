<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MyInstitutionStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        if ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $institution = $this->route('my_institution');

            //access the institution policy
            return auth('admin')->user()->can('updateMyInstitution', $institution);

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
            'introduction' => 'nullable',
            'times_location' => 'nullable',
        ];
    }
}
