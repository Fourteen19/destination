<?php

namespace App\Http\Livewire\Admin;

use App\Models\Content;
use Livewire\Component;
use App\Models\ContentLive;
use App\Models\HomepageSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomepageSettingsForm extends Component
{

    use AuthorizesRequests;

    protected $listeners = ['article_selector' => 'articleSelector',
                            'formHasError'
                            ];

    public $activeTab;
    public $error = FALSE;

    public $year7_slot1_type, $year7_slot2_type, $year7_slot3_type, $year7_slot4_type, $year7_slot5_type, $year7_slot6_type;
    public $year8_slot1_type, $year8_slot2_type, $year8_slot3_type, $year8_slot4_type, $year8_slot5_type, $year8_slot6_type;
    public $year9_slot1_type, $year9_slot2_type, $year9_slot3_type, $year9_slot4_type, $year9_slot5_type, $year9_slot6_type;
    public $year10_slot1_type, $year10_slot2_type, $year10_slot3_type, $year10_slot4_type, $year10_slot5_type, $year10_slot6_type;
    public $year11_slot1_type, $year11_slot2_type, $year11_slot3_type, $year11_slot4_type, $year11_slot5_type, $year11_slot6_type;
    public $year12_slot1_type, $year12_slot2_type, $year12_slot3_type, $year12_slot4_type, $year12_slot5_type, $year12_slot6_type;
    public $year13_slot1_type, $year13_slot2_type, $year13_slot3_type, $year13_slot4_type, $year13_slot5_type, $year13_slot6_type;
    public $year14_slot1_type, $year14_slot2_type, $year14_slot3_type, $year14_slot4_type, $year14_slot5_type, $year14_slot6_type;

    public $year7_slot1_article, $year7_slot2_article, $year7_slot3_article, $year7_slot4_article, $year7_slot5_article, $year7_slot6_article;
    public $year8_slot1_article, $year8_slot2_article, $year8_slot3_article, $year8_slot4_article, $year8_slot5_article, $year8_slot6_article;
    public $year9_slot1_article, $year9_slot2_article, $year9_slot3_article, $year9_slot4_article, $year9_slot5_article, $year9_slot6_article;
    public $year10_slot1_article, $year10_slot2_article, $year10_slot3_article, $year10_slot4_article, $year10_slot5_article, $year10_slot6_article;
    public $year11_slot1_article, $year11_slot2_article, $year11_slot3_article, $year11_slot4_article, $year11_slot5_article, $year11_slot6_article;
    public $year12_slot1_article, $year12_slot2_article, $year12_slot3_article, $year12_slot4_article, $year12_slot5_article, $year12_slot6_article;
    public $year13_slot1_article, $year13_slot2_article, $year13_slot3_article, $year13_slot4_article, $year13_slot5_article, $year13_slot6_article;
    public $year14_slot1_article, $year14_slot2_article, $year14_slot3_article, $year14_slot4_article, $year14_slot5_article, $year14_slot6_article;

    public $year7Slot1IsVisible, $year7Slot2IsVisible, $year7Slot3IsVisible, $year7Slot4IsVisible, $year7Slot5IsVisible, $year7Slot6IsVisible;
    public $year8Slot1IsVisible, $year8Slot2IsVisible, $year8Slot3IsVisible, $year8Slot4IsVisible, $year8Slot5IsVisible, $year8Slot6IsVisible;
    public $year9Slot1IsVisible, $year9Slot2IsVisible, $year9Slot3IsVisible, $year9Slot4IsVisible, $year9Slot5IsVisible, $year9Slot6IsVisible;
    public $year10Slot1IsVisible, $year10Slot2IsVisible, $year10Slot3IsVisible, $year10Slot4IsVisible, $year10Slot5IsVisible, $year10Slot6IsVisible;
    public $year11Slot1IsVisible, $year11Slot2IsVisible, $year11Slot3IsVisible, $year11Slot4IsVisible, $year11Slot5IsVisible, $year11Slot6IsVisible;
    public $year12Slot1IsVisible, $year12Slot2IsVisible, $year12Slot3IsVisible, $year12Slot4IsVisible, $year12Slot5IsVisible, $year12Slot6IsVisible;
    public $year13Slot1IsVisible, $year13Slot2IsVisible, $year13Slot3IsVisible, $year13Slot4IsVisible, $year13Slot5IsVisible, $year13Slot6IsVisible;
    public $year14Slot1IsVisible, $year14Slot2IsVisible, $year14Slot3IsVisible, $year14Slot4IsVisible, $year14Slot5IsVisible, $year14Slot6IsVisible;

    public $year7FeatureArticleSlot1, $year8FeatureArticleSlot1, $year9FeatureArticleSlot1, $year10FeatureArticleSlot1, $year11FeatureArticleSlot1, $year12FeatureArticleSlot1, $year13FeatureArticleSlot1, $year14FeatureArticleSlot1;
    public $year7FeatureArticleSlot1IsVisible, $year8FeatureArticleSlot1IsVisible, $year9FeatureArticleSlot1IsVisible, $year10FeatureArticleSlot1IsVisible, $year11FeatureArticleSlot1IsVisible, $year12FeatureArticleSlot1IsVisible, $year13FeatureArticleSlot1IsVisible, $year14FeatureArticleSlot1IsVisible;

    protected $rules = [];

    protected $messages = [];

    public function mount()
    {

        $homepageSettings = HomepageSettings::where('client_id', session()->get('adminClientSelectorSelected') )->orderby('school_year', 'ASC')->get();

        $rowId = 0;
        for($year=7;$year<=14;$year++)
        {

            $data = $homepageSettings[$rowId];
            for($slot=1;$slot<=6;$slot++)
            {
                //gets the slot type
                $this->{'year'.$year.'_slot'.$slot.'_type'} = $data->{'dashboard_slot_'.$slot.'_type'};

                //if `managed`
                if ($this->{'year'.$year.'_slot'.$slot.'_type'} == "managed")
                {
                    $this->{'year'.$year.'Slot'.$slot.'IsVisible'} = True; //set the article select to be visible
                    if ($data->{'dashboard_slot_'.$slot.'_id'})
                    {
                        // dd( $data->{'dashboard_slot_'.$slot.'_id'} );
                        $slotData = Content::where('id', '=', $data->{'dashboard_slot_'.$slot.'_id'} )->select('uuid')->first()->toArray();
                        $this->{'year'.$year.'_slot'.$slot.'_article'} = $slotData['uuid'];
                    }
                }


                /* if ($data->article_feature_slot_1)
                {
                    $this->year7FeatureArticleSlot1 = $data->getFeaturedArticle()->select('uuid', 'title')->first()->toArray();
                } */


                if ($data->article_feature_slot_1)
                {

                    $slotData = Content::where('id', '=', $data->article_feature_slot_1 )->select('uuid')->first();
                    if ($slotData)
                    {
                        $this->{'year'.$year.'FeatureArticleSlot1'} = $slotData['uuid'];

                    }

                }

            }

            $rowId++;
        }

        $this->activeTab = "year7";

    }




    public function articleSelector($data)
    {
        if ($data[1] == NULL){
            $this->{$data[0]} = NULL;
        } else {
            $this->{$data[0]} = $data[1];
        }

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
     * formHasError
     * adds data in the error basket to display an error in the main component
     * This erros does not belong to any field and is not shown
     * This event is triggered by children components when their validation fails
     *
     * @param  mixed $name
     * @return void
     */
    public function formHasError($name)
    {
        $this->addError('error', 'woops');

    }



    /**
     * store
     * triggered when saving the form
     *
     * @return void
     */
    public function store()
    {

        $this->resetErrorBag();

        $this->rules = [];

        //stores all the radio results in an array
        $data = [];
        for($year=7;$year<=14;$year++)
        {
            for($slot=1;$slot<=6;$slot++)
            {
                $data['year'.$year.'_slot'.$slot.'_type'] = $this->{'year'.$year.'_slot'.$slot.'_type'};
                $this->rules['year'.$year.'_slot'.$slot.'_type'] = 'required|in:managed,algorithmic';
                $this->rules['year'.$year.'_slot'.$slot.'_article'] = 'required_if:year'.$year.'_slot'.$slot.'_type,managed';
            }
        }

        //send event to all Livewire nested component to run validation on dropdown.
        //The state of all radio is passed so the nested component can run the correct validation
        //$this->emit('runValidation', $data);


        $validatedData = $this->validate($this->rules, $this->messages);

        DB::beginTransaction();

        try
        {

           // dd($this);
            $toSave = [];
            for($year=7;$year<=14;$year++)
            {
                for($slot=1;$slot<=6;$slot++)
                {
                    //gets the slot type
                    $toSave['dashboard_slot_'.$slot.'_type'] = $this->{'year'.$year.'_slot'.$slot.'_type'};
                    if ($toSave['dashboard_slot_'.$slot.'_type'] == 'managed')
                    {

                        $article = Content::where('uuid', '=', $this->{'year'.$year.'_slot'.$slot.'_article'} )->select('id')->first()->toArray();
                        $toSave['dashboard_slot_'.$slot.'_id'] = $article['id'];

                    } else {
                        $toSave['dashboard_slot_'.$slot.'_id'] = NULL;
                    }
                }


                if ($this->{'year'.$year.'FeatureArticleSlot1'})
                {
                    $article = Content::where('uuid', '=', $this->{'year'.$year.'FeatureArticleSlot1'} )->select('id')->first()->toArray();
                    $toSave['article_feature_slot_1'] = $article['id'];
                } else {
                    $toSave['article_feature_slot_1'] = NULL;
                }

                HomepageSettings::where('school_year', '=', $year)->where('client_id', session()->get('adminClientSelectorSelected') )->update($toSave);

            }


            DB::commit();

            Session::flash('success', 'Your homepage settings have been saved Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'An error occured, your homepage settings could not be saved');

        }


    }


    public function render()
    {
        return view('livewire.admin.homepage-settings-form');
    }
}
