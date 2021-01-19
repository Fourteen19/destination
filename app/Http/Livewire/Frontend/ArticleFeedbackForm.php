<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\ArticlesService;


class ArticleFeedbackForm extends Component
{

    protected $listeners = ['articleScroll100PerCent' => 'articleScroll100PerCent',
                            'articleScroll75PerCent' => 'articleScroll75PerCent',
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

        //gets the data already saved by the user from DB
        $user_article_data = Auth::guard('web')->user()->articleReadThisYear($article->id)->first();

        //initialise the article interaction flags
        $this->timerFullyReadSubmitted = ($user_article_data->pivot->timer_fully_read_triggered == 'Y') ? 1 : 0; // dynamic timer based on the number  of words
        $this->timer15Submitted = ($user_article_data->pivot->timer_15_triggered == 'Y') ? 1 : 0; //15 seconds timer
        $this->articleRead100PerCentScrolled = ($user_article_data->pivot->scroll_100_percent == 'Y') ? 1 : 0; //scrolled down 100% of article
        $this->articleRead75PerCentScrolled = ($user_article_data->pivot->scroll_75_percent == 'Y') ? 1 : 0; //scrolled down 75% of article
        $this->feedbackSubmitted = (!is_null($user_article_data->pivot->user_feedback)) ? 1 : 0; // feedback already submitted?


        //gets the current self assessment
        $this->selfAssessment = app('selfAssessmentSingleton')->getSelfAssessment();



        $this->articleService = new ArticlesService();

        //gets the tags we need to update
        $this->userAssessmentTagsToUpdate = $this->articleService->getArticleAndAssessmentTags($article);


    }


    public function submit()
    {

        $validatedData = $this->validate();

        if (!is_null($this->articleId))
        {
            $this->articleService = new ArticlesService();
            //passes as parameter the article Id and the first character of the 'relevant' value, + capitalised
            $this->articleService->updateArticleInteractionFeedbackReceivedByUser($this->articleId, ['user_feedback' => strtoupper($validatedData['relevant'][0]), 'feedback_date' => \Carbon\Carbon::now()] );

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

                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 1);

                $this->articleService = new ArticlesService();
                $this->articleService->updateArticleInteractionFeedbackReceivedByUser($this->articleId, ['timer_fully_read_triggered' => 'Y']);

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

                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 1);

                $this->articleService = new ArticlesService();
                $this->articleService->updateArticleInteractionFeedbackReceivedByUser($this->articleId, ['timer_15_triggered' => 'Y']);
            }

        }

        $this->timer15Submitted = 1;

    }





    /**
     * articleScroll100PerCent
     * triggered by JS after the user scrolls all the way down the article
     *
     * @return void
     */
    public function articleScroll100PerCent()
    {

        //if this event has not been fired yet
        // and the form has not been submitted
        if ( ($this->articleRead100PerCentScrolled == 0) && ($this->feedbackSubmitted == 0) )
        {

            //if there are tags to update
            if (count($this->userAssessmentTagsToUpdate) > 0)
            {

                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 1);

                $this->articleService = new ArticlesService();
                $this->articleService->updateArticleInteractionFeedbackReceivedByUser($this->articleId, ['scroll_100_percent' => 'Y', 'scroll_75_percent' => 'Y']);
            }

        }

        $this->articleRead100PerCentScrolled = 1;

    }



    /**
     * articleScroll75PerCent
     * triggered by JS after the user scrolls 75% down the article
     *
     * @return void
     */
    public function articleScroll75PerCent()
    {

        //if this event has not been fired yet
        // and the form has not been submitted
        if ( ($this->articleRead75PerCentScrolled == 0) && ($this->feedbackSubmitted == 0) )
        {

            //if there are tags to update
            if (count($this->userAssessmentTagsToUpdate) > 0)
            {

                app('selfAssessmentSingleton')->updateTagsScore($this->userAssessmentTagsToUpdate, $this->selfAssessment->id, 2);

                $this->articleService = new ArticlesService();
                $this->articleService->updateArticleInteractionFeedbackReceivedByUser($this->articleId, ['scroll_75_percent' => 'Y']);
            }

        }

        $this->articleRead75PerCentScrolled = 1;

    }


    public function render()
    {
        return view('livewire.frontend.article-feedback-form');
    }

}
