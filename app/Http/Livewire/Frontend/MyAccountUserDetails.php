<?php

namespace App\Http\Livewire\Frontend;

use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class MyAccountUserDetails extends Component
{

    public $postcode;
    public $primaryEmail;
    public $confirmPrimaryEmail;
    public $personalEmail;
    public $password;
    public $password_confirmation;
    public $updateMessage;

    //postcode validation is declared in an array to prevent validation errors as the pipe symbol is used
    protected $rules = [
        'postcode' => array('present', 'regex:/^([A-Za-z][A-Ha-hJ-Yj-y]?[0-9][A-Za-z0-9]? ?[0-9][A-Za-z]{2}|[Gg][Ii][Rr] ?0[Aa]{2})$/'),
        'confirmPrimaryEmail' => 'required|email|same:primaryEmail',
        'password' => 'nullable|string|min:8',
        'password_confirmation' => 'nullable|same:password',
    ];


    public function mount()
    {
        $this->postcode = Auth::guard('web')->user()->postcode;
        $this->primaryEmail = Auth::guard('web')->user()->email;
        $this->confirmPrimaryEmail = Auth::guard('web')->user()->email;
        $this->personalEmail = Auth::guard('web')->user()->personal_email;
        $this->updateMessage = "";
    }

    public function submit()
    {

        $this->rules['primaryEmail'] = 'required|email|max:255|unique:users,personal_email,'.Auth::guard('web')->user()->id.',id,deleted_at,NULL|unique:users,email,'.Auth::guard('web')->user()->id.',id,deleted_at,NULL';
        $this->rules['personalEmail'] = 'nullable|email|max:255|unique:users,personal_email,'.Auth::guard('web')->user()->id.',id,deleted_at,NULL|unique:users,email,'.Auth::guard('web')->user()->id.',id,deleted_at,NULL';

        $this->updateMessage = "";

        $validatedData = $this->validate();

        DB::beginTransaction();

        try {

            if ($this->password)
            {
                $passwordArray = ['password' => Hash::make($validatedData['password']) ];
            } else {
                $passwordArray = [];
            }

            Auth::guard('web')->user()->update(array_merge(['postcode' => $validatedData['postcode'],
                                                            'email' => $validatedData['primaryEmail'],
                                                            'personal_email' => (empty($validatedData['personalEmail'])) ? NULL : $validatedData['personalEmail'],
                                                           ],
                                                           $passwordArray
                                                        )
                                                );

            DB::commit();

            $this->updateMessage = "Your profile has been saved";

        } catch (\Exception $e) {

            DB::rollback();

            $this->updateMessage = "Your profile could not be saved. Please try again later";
        }

    }

    public function render()
    {
        return view('livewire.frontend.my-account-user-details');
    }
}
