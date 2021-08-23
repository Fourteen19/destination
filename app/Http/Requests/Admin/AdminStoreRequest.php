<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
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
            'title' => 'required|string|in:Mr,Mrs,Ms,Miss,Dr',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'photo' => 'nullable',
        ];

        //if we create a level 2 admin, we MUST assign them a client
        if (in_array($this->role, [
            config('global.admin_user_type.Client_Admin'),
            config('global.admin_user_type.Client_Content_Admin'),
            config('global.admin_user_type.Advisor'),
            config('global.admin_user_type.Teacher'),
            config('global.admin_user_type.Third_Party_Admin'),
            config('global.admin_user_type.Employer') ]
        ))
        {

            //if the logged in user is a global admin
            if (isGlobalAdmin())
            {
                $rules['client'] = 'required|uuid';
            } else {
                //if the logged in user is a client admin, we do not need the client_id
            }
        }

        if (in_array($this->role, [
                                    config('global.admin_user_type.Advisor'),
                                    config('global.admin_user_type.Teacher'),]))
        {
            $rules['institutions'] = '';
            //$rules['institutions'] = 'required';
            //$rules['institutions.*'] = 'required|uuid';
            $rules['contact_me'] = 'boolean'; //The field must be yes, on, 1, or true
        }


        if (in_array($this->role, [config('global.admin_user_type.Employer'),]))
        {
            $rules['employer'] = 'required';
        }


        //if the form has been submitted with POST
        if ($this->getMethod() == 'POST') {

            $rules['password'] = 'required|min:8|same:confirm-password';
            $rules['email'] .= '|unique:admins,email|unique:users,email';

        //if the form has been submitted with PATCH
        } elseif ($this->getMethod() == 'PATCH') {

            $admin = $this->route('admin');

            $frontendUser = $admin->frontendUser;
            if ($frontendUser){
                //$emailUserValidation = '|unique:users,email,'.$frontendUser->id.'|unique:users,personal_email,'.$frontendUser->id;
                $emailUserValidation = '|unique:users,email,'.$frontendUser->id;
            } else {
                $emailUserValidation = '';
            }

            $rules['password'] = 'nullable|same:confirm-password|min:8';

            //checks the email address is unique in the admins table as well as in the users table
            $rules['email'] .= '|unique:admins,email,'.$this->admin->id.$emailUserValidation;
        }

        $rules['role'] = 'required';

        return $rules;
    }



    public function messages()
    {
        return [
            'institutions.required' => 'Please select an institution',
            'email.unique' => 'This email address is already in use by another administrator or by a school user',
            'employer.required' => 'Please select an employer',
        ];
    }


}
