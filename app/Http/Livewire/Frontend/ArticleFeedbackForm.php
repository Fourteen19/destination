<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\ContentLive;
use App\Services\Frontend\ArticlesService;


class ArticleFeedbackForm extends Component
{

    protected $listeners = ['articleRead100' => 'articleRead100',
                            'articleRead75' => 'articleRead75',
    ];

    public $relevant;
    public $feedbackSubmitted; // used to check if the feedback has been provided using the form

    public $articleRead75PerCentScrolled = 0;
    public $articleRead100PerCentScrolled = 0;
    public $timer15Submitted = 0;
    public $timerFullyReadSubmitted = 0;

    public $userAssessmentTagsToUpdate;
    public $selfAssessment;

    public $articleId;
    private $articleService;

    public $debug;

    protected $rules = [
        'relevant' =>'required|in:"yes", "no"'
    ];

    protected $messages = [
        'relevant.required' => 'Please indicate if this page was relevant',
        'relevant.in' => 'Please indicate if this page was relevant',
    ];

    //setup of the component
    public function mount(ContentLive $article)
    {

        $this->articleId = $article->id;

        $this->timer15Submitted = 0; //15 seconds timer
        $this->timerFullyReadSubmitted = 0; // dynamic timer based on the number  of words
        $this->articleRead100PerCentScrolled = 0; //scrolled down 100% of article
        $this->articleRead75PerCentScrolled = 0; //scrolled down 75% of article

        //gets the current self assessment
        $this->selfAssessment = app('selfAssessmentSingleton')->getSelfAssessment();


        $this->articleService = new ArticlesService();
        //gets the tags we need to update
        $this->userAssessmentTagsToUpdate = $this->articleService->getArticleAndAssessmentTags($article);

        $this->feedbackSubmitted = 0;


        $this->debug="";
    }


    public function submit()
    {

        $validatedData = $this->validate();

        if (!is_null($this->articleId))
        {
            $this->articleService = new ArticlesService();
            //passes as parameter the article Id and the first character of the 'relevant' value, + capitalised
            $this->articleService->feedbackReceivedByUser($this->articleId, strtoupper($validatedData['relevant'][0]));

            //if the article was not relevant
            if ($validatedData['relevant'] == 'no')
            {

                ////counter used to calculate by how much we need to revert the score
                $this->revertToScore = 0;

                if ($this->timer15Submitted == 1){
                    $this->revertToScore += 1;
                }

                if ($this->timerFullyReadSubmitted == 1){
                    $this->revertToScore += 1;
                }

                if ($this->articleRead75PerCentScrolled == 1){
                    $this->revertToScore += 2;
                }

                if ($this->articleRead100PerCentScrolled == 1){
                    $this->revertToScore += 1;
                }

                //upgrades the tags score
                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, -$this->revertToScore);

            }

            $this->feedbackSubmitted = 1;

        }

    }




    /**
     * timerArticleIsRead
     * The dyanmic timer to read the article has passed
     *
     * @return void
     */
    public function timerArticleIsRead()
    {

        //if this event has not been fired yet
        // and the form has not been submitted
        if ( ($this->timerFullyReadSubmitted == 0) && ($this->feedbackSubmitted == 0) )
        {

            //if there are tags to update
            if (count($this->userAssessmentTagsToUpdate) > 0)
            {
                $this->debug.="1";
                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 1);

            }

        }

        $this->timerFullyReadSubmitted = 1;

    }




    /**
     * timer15
     * triggered by JS after 15 seconds of reading the article
     *
     * @return void
     */
    public function timer15()
    {

        //if this event has not been fired yet
        // and the form has not been submitted
        if ( ($this->timer15Submitted == 0) && ($this->feedbackSubmitted == 0) )
        {

            //if there are tags to update
            if (count($this->userAssessmentTagsToUpdate) > 0)
            {
                $this->debug.="2";
                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 1);

            }

        }

        $this->timer15Submitted = 1;

    }





    /**
     * articleRead100
     * triggered by JS after the user scrolls all the way down the article
     *
     * @return void
     */
    public function articleRead100()
    {

        //if this event has not been fired yet
        // and the form has not been submitted
        if ( ($this->articleRead100PerCentScrolled == 0) && ($this->feedbackSubmitted == 0) )
        {

            //if there are tags to update
            if (count($this->userAssessmentTagsToUpdate) > 0)
            {
                $this->debug.="3";
                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 1);

            }

        }

        $this->articleRead100PerCentScrolled = 1;

    }



    /**
     * articleRead75
     * triggered by JS after the user scrolls 75% down the article
     *
     * @return void
     */
    public function articleRead75()
    {

        //if this event has not been fired yet
        // and the form has not been submitted
        if ( ($this->articleRead75PerCentScrolled == 0) && ($this->feedbackSubmitted == 0) )
        {

            //if there are tags to update
            if (count($this->userAssessmentTagsToUpdate) > 0)
            {
                $this->debug.="4";
                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 2);

            }

        }

        $this->articleRead75PerCentScrolled = 1;

    }


    public function render()
    {
        return view('livewire.frontend.article-feedback-form');
    }

}
