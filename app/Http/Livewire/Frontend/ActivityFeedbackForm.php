<?php

namespace App\Http\Livewire\Frontend;

use Ramsey\Uuid\Uuid;
use App\Models\Content;
use Livewire\Component;
use App\Models\ContentLive;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ActivityFeedbackForm extends Component
{

    public $uuid;
    public $questionsList = [];


    public function mount($uuid)
    {

        if (Str::isUuid($uuid))
        {

            //gets the live activity content
            $contentLive = ContentLive::where('uuid', $uuid)->first();

            $this->uuid = $contentLive->uuid;

            //loads the activity related questions
            $this->questionsList = [];
            $questions = $contentLive->relatedActivityQuestions;
            foreach($questions as $key => $value)
            {
                $this->questionsList[] = [
                                    'question_id' => $key + 1,
                                    'uuid' => $value['uuid'],
                                    'text' => $value['text'],
                                    'answer' => ''
                                ];
            }


            $questions = $contentLive->relatedActivityQuestions_data()->get();
            //dd($questions);


            //gets the activity content
            $content = Content::where('uuid', $uuid)->first();

            $content->users_activities()->attach( Auth::guard('web')->user()->id );




            foreach($questions as $key => $value)
            {

                Auth::guard('web')->user()->activities_answers()->save($value, ['answer' => 'ffffff']);

            }

        } else {
            abort(404);
        }

    }


    public function render()
    {
        return view('livewire.frontend.activity-feedback-form');
    }
}
