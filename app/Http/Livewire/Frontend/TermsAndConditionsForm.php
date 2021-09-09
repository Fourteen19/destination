<?php

namespace App\Http\Livewire\Frontend;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TermsAndConditionsForm extends Component
{
    public $terms;
    public $displayForm = 'N';
    public $termsAccepted;

    //setup of the component
    public function mount()
    {

        $user_data = User::where('id', Auth::guard('web')->user()->id)->select('accept_terms')->first()->toArray();

        $this->termsAccepted = $user_data['accept_terms'];

        if ($this->termsAccepted == 'N')
        {
            $this->displayForm = 'Y';
        }
    }



    /**
     * updated
     */
    public function updated($propertyName)
    {

        if ($propertyName == "terms"){

            if ($this->terms == 'terms')
            {
                $this->termsAccepted = 'Y';
            } else {
                $this->termsAccepted = 'N';
            }

        }

    }



    /**
     * submit
     *
     * @return void
     */
    public function submit()
    {
        //if the form was displayed, save to DB
        if ($this->displayForm == 'Y')
        {

            DB::beginTransaction();

            try {

                User::where('id', Auth::guard('web')->user()->id)->update(['accept_terms' => $this->termsAccepted]);

                DB::commit();

                if (Auth::guard('web')->user()->type == "user")
                {
                     //redirects to the password reset screen
                    redirect()->route('frontend.get-started', ['clientSubdomain' => session('fe_client.subdomain') ] );

                } else {

                    //redirects to the dashboard
                    redirect()->route('frontend.self-assessment.career-readiness.edit', ['clientSubdomain' => session('fe_client.subdomain') ] );

                }

            } catch (\Exception $e) {

                DB::rollback();

                Session::flash('error', 'Could not update your terms and conditions settings');

            }

        } else {

            //redirects
            redirect()->route('frontend.get-started', ['clientSubdomain' => session('fe_client.subdomain') ] );

        }
    }




    public function render()
    {

        return view('livewire.frontend.terms-and-conditions-form');

    }
}
