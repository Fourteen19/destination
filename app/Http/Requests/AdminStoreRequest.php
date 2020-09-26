<?php

namespace App\Http\Requests;

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
            return Auth('admin')->user()->can('admin-create', Admin::class);
        
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'role' => 'required',
        ];

        //If we create a level 2 admin, we MUST assign them a client
        if ( ($this->role == "Client Admin") || ($this->role == "Advisor") || ($this->role == "Client Content Admin") || ($this->role == "Third Party Admin") )
        {
            $rules['client'] = 'required|uuid';
        }

        if ($this->role == "Advisor")
        {
            $rules['institution'] = 'required|uuid';
        }




        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST') {

            $rules['password'] = 'required|min:8|same:confirm-password';
            $rules['email'] .= '|unique:admins,email';
        
        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $rules['password'] = 'same:confirm-password|min:8';
            $rules['email'] .= '|unique:admins,email,'.$this->admin->id;
        }

        return $rules;
    }
}
