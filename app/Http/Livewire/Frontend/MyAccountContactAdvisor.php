<?php

namespace App\Http\Livewire\Frontend;


use Livewire\Component;
use App\Mail\ContactAdvisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\GlobalSettingsService;
use App\Services\Frontend\AdvisorService;

class MyAccountContactAdvisor extends Component
{

    public $questionTypeList;
    public $questionType;
    public $questionText;
    public $formMessage;
    public $success;

    protected $rules = [
        'questionType' => 'required',
        'questionText' => 'required'
    ];


    public function mount()
    {

        $this->globalSettingsService = new GlobalSettingsService();
        $this->questionTypeList = $this->globalSettingsService->getQuestionTypeList();


        //updates the rules with the only allowed types
        $this->rules['questionType'] = "required|in:'".implode("','", $this->questionTypeList)."'";

        //initialises the Type when loading
        $this->questionType = $this->questionTypeList[0];

        $this->success = 0;
        $this->questionText = "";
        $this->formMessage = "";
    }

    public function submit(Request $request)
    {

        $validatedData = $this->validate();

        try {

            $advisorService = new AdvisorService();
            $institutionAdvisor = $advisorService->getAdvisorDetailsForCurrentUser();

            if (!empty($institutionAdvisor))
            {
                $data['email_title'] = "You have been contacted by a user";
                $data['first_name'] = Auth::guard('web')->user()->first_name;
                $data['last_name'] = Auth::guard('web')->user()->last_name;
                $data['institution'] = Auth::guard('web')->user()->institution->name;
                $data['questionType'] = $validatedData['questionType'];
                $data['questionText'] = $validatedData['questionText'];

                //if the advisor is contacttable AND the email has been set
                if ( ($institutionAdvisor->contact_me == "Y") && (!empty($institutionAdvisor->email)) )
                {
                    Mail::to($institutionAdvisor->email)->send(new ContactAdvisor($data));
                    $this->formMessage = "Your email has been sent to your advisor";
                    $this->success = 1;
                } else {
                    $this->formMessage = "Your advisor can not be contacted at this moment";
                }

            } else {
                $this->formMessage = "Your advisor can not be contacted at this moment";
            }

        } catch (Exception $exception) {

            $this->formMessage = "Your email could not be sent. Please try again later";
        }

    }

    public function render()
    {
        return view('livewire.frontend.my-account-contact-advisor');
    }

}
