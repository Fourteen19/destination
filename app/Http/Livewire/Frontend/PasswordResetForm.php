<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PasswordResetForm extends Component
{

    public $password;
    public $password_confirmation;
    public $updateMessage;
    public $result;

/*     protected $rules = [
        'password' => 'required|string|min:8',
        'password_confirmation' => 'required|same:password',
    ]; */


   /*  protected $rules = [
        'password' => 'required',
        'password_confirmation' => '',
    ]; */

    //setup of the component
    public function mount()
    {

        $this->updateMessage = "";

    }


    /**
     * submit
     *
     * @return void
     */
    public function submit()
    {

        $this->updateMessage = "";
        //$validatedData = $this->validate();

        $validatedData = $this->validate([
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ]);


        DB::beginTransaction();

        try {

            if ($this->password)
            {
                $passwordArray = ['password' => Hash::make($validatedData['password']),
                                  'password_reset' => 'Y',
                                     ];
            } else {
                $passwordArray = [];
            }

            $this->result = Auth::guard('web')->user()->update($passwordArray);

            DB::commit();

            $this->updateMessage = "Your new password has been saved";

        } catch (\Exception $e) {

            Log::error($e);

            DB::rollback();

            $this->updateMessage = "Your new password could not be saved. Please try again later";
        }



    }


    public function goToSelfAssessment()
    {
        //redirects to the self assessment screen
        redirect()->route('frontend.self-assessment.career-readiness.edit', ['clientSubdomain' => session('fe_client.subdomain') ] );
    }


    public function render()
    {
        return view('livewire.frontend.password-reset-form');

    }
}
