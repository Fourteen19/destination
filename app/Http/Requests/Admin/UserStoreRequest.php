<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class UserStoreRequest extends FormRequest
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
            return Auth('admin')->user()->can('create', User::class);

        } elseif ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $user = $this->route('user');

            //access the admin policy
            return auth('admin')->user()->can('update', $user);

        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            //'personal_email' => 'email',
            'institution_id' => 'required|numeric',
            'birth_date' => 'date_format:d/m/Y',
            'school_year' => 'numeric',
            'postcode' => 'string|max:10',
            'rodi' => 'numeric',
            'roni' => 'numeric',
            'tagsSubjects' => '',
            'tagsLscs' => '',
            'tagsRoutes' => '',
            'tagsYears' => '',
            'tagsSectors' => '',
        ];


        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST') {

            $rules['password'] = 'required|min:8|same:confirm-password';
            $rules['email'] .= '|unique:users,email';

        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $rules['password'] = 'nullable|same:confirm-password|min:8';
            $rules['email'] .= '|unique:users,email,'.$this->user->id;
        }

        return $rules;

    }

}
