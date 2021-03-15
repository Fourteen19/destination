<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            return Auth('admin')->user()->can('create', Admin::class);

        } elseif ($this->getMethod() == 'PATCH') {

            //gets the admin variable
            //$this is Request
            $admin = $this->route('admin');

            //access the admin policy
            return auth('admin')->user()->can('update', $admin);

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
            'title' => 'required|string|in:Mr,Mrs,Miss,Dr',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
        ];

        //if we create a level 2 admin, we MUST assign them a client
        if ( ($this->role == "Client Admin") || ($this->role == "Advisor") || ($this->role == "Client Content Admin") || ($this->role == "Third Party Admin") )
        {
            //if the logged in user is a global admin
            if (isGlobalAdmin())
            {
                $rules['client'] = 'required|uuid';
            } else {
                //if the logged in user is a client admin, we do not need the client_id
            }
        }

        if ($this->role == "Advisor")
        {
            $rules['institutions'] = 'required';
            $rules['institutions.*'] = 'required|uuid';
            $rules['contact_me'] = 'boolean'; //The field must be yes, on, 1, or true
        }

        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST') {

            $rules['password'] = 'required|min:8|same:confirm-password';
            $rules['email'] .= '|unique:admins,email';

        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $rules['password'] = 'nullable|same:confirm-password|min:8';
            $rules['email'] .= '|unique:admins,email,'.$this->admin->id;
        }

        $rules['role'] = 'required';

        return $rules;
    }



    public function messages()
    {
        return [
            'institutions.required' => 'Please select an institution',
        ];
    }


}
