<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\ContentLive;
use Illuminate\Support\Facades\Auth;

class ArticleFeedbackForm extends Component
{

    protected $listeners = ['articleRead100' => 'articleRead100',
                            'articleRead75' => 'articleRead75',
    ];

    public $relevant;
    public $feedbackSubmitted; // used to check if the feedback has been provided using the form
    public $feedbackDoneBefore; // used to check if the feedback had been provided in a prior visi to the article

    public $time;
    public $percentread;

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
        //dd($article);
//->where('content_live_id', $article->id)
        //Auth::guard('web')->user()->articleReadThisYear($article->id)->get();
        //dd(Auth::guard('web')->user()->articlesReadThisYear()->where('content_live_id', $article->id)->get());
        //auth:guard('web')->user()->articles();

        $this->time = 0;
        $this->percentread = 0;



        $this->feedbackSubmitted = 0;
        $this->feedbackDoneBefore = 0;

    }

    public function submit()
    {

        $this->validate();

        $this->feedbackSubmitted = 1;

    }

    public function theArticleHasBeenRead()
    {

        $this->time += 15;

    }

    public function articleRead100()
    {
        $this->time = 100;
        $this->percentread = 100;
    }

    public function articleRead75()
    {
        $this->time = 0;
        $this->percentread = 75;
    }

    public function render()
    {


        return view('livewire.frontend.article-feedback-form');
    }

}
