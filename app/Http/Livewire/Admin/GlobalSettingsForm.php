<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\GlobalSettings;
use Illuminate\Support\Facades\DB;
use App\Services\GlobalSettingsService;
use Illuminate\Support\Facades\Session;

class GlobalSettingsForm extends Component
{
    public $globalSettings;
//
    public $activeTab;

    public $contactAdvisorQuestionTypes = [];
    public $contactAdvisorQuestionTypesIteration  = 1;

    protected $rules = [
        'globalSettings.articles_wordcount_read_per_minute' => 'required|numeric|digits_between:1,3|integer',
        'contactAdvisorQuestionTypes.*' => 'required',
    ];

    protected $messages = [
        'contactAdvisorQuestionTypes.*.required' => 'Please enter the question type',
    ];



    //setup of the component
    public function mount()
    {

        $globalSettingsService = new GlobalSettingsService();

        //gets the question type
        $this->contactAdvisorQuestionTypes = $globalSettingsService->getQuestionTypeList();

        //gets the Global Settings  object
        $this->globalSettings = $globalSettingsService->globalSettings;

       // dd($this->globalSettingsService->globalSettings);
        $this->activeTab = "articles";

    }


    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }



    /**
     * Add a question type
     */
    public function addQuestionType()
    {
        $this->contactAdvisorQuestionTypes[] = "";
    }


    /**
     * Updates the order of the question Types
     *
     */
    public function updateQuestionTypeOrder($QuestionTypeOrder)
    {
        $tmpQuestionTypes = [];

        foreach($QuestionTypeOrder as $key => $value)
        {
            $tmpQuestionTypes[] = $this->contactAdvisorQuestionTypes[$value['value']];
        }

        $this->contactAdvisorQuestionTypes = $tmpQuestionTypes;

    }


    /**
     * Remove question type
     */
    public function removeQuestionType($questionTypeIteration)
    {
        unset($this->contactAdvisorQuestionTypes[$questionTypeIteration]);
    }




    public function submit()
    {

        $validatedData = $this->validate();

        DB::beginTransaction();

        try
        {

            $this->globalSettings->update(['articles_wordcount_read_per_minute' => $validatedData['globalSettings']['articles_wordcount_read_per_minute'],
                                      'topic_advisor_questions' => json_encode(["text" => $validatedData['contactAdvisorQuestionTypes']])
                                    ]);

            DB::commit();

            Session::flash('success', 'Your global settings have been saved Successfully');

        } catch (\exception $e) {

            DB::rollback();

            Session::flash('fail', 'An error occured, your global settings could not be saved');

        }
    }



    public function render()
    {

        return view('livewire.admin.global-settings-form');

    }

}
