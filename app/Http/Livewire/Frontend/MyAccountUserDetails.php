<?php

namespace App\Http\Livewire\Frontend;

use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MyAccountUserDetails extends Component
{

    public $postcode;
    public $personalEmail;
    public $updateMessage;

    //postcode validation is declared in an array to prevent validation errors as the pipe symbol is used
    protected $rules = [
        'personalEmail' => 'present|email',
        'postcode' => array('present', 'regex:/^([A-Za-z][A-Ha-hJ-Yj-y]?[0-9][A-Za-z0-9]? ?[0-9][A-Za-z]{2}|[Gg][Ii][Rr] ?0[Aa]{2})$/')
    ];


    public function mount()
    {
        $this->postcode = Auth::guard('web')->user()->postcode;
        $this->personalEmail = Auth::guard('web')->user()->personal_email;
        $this->updateMessage = "";
    }

    public function submit()
    {

        $this->updateMessage = "";
        $validatedData = $this->validate();

        try {

            Auth::guard('web')->user()->update(['postcode' => $validatedData['postcode'], 'personal_email' => $validatedData['personalEmail']]);
            $this->updateMessage = "Your profile has been saved";

        } catch (Exception $exception) {
            $this->updateMessage = "Your profile could not be saved. Please try again later";
        }

    }

    public function render()
    {
        return view('livewire.frontend.my-account-user-details');
    }
}
