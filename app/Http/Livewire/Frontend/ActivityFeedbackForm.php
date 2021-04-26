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

            //attach a user to an activity
           /*  $content->users_activities()->attach( Auth::guard('web')->user()->id );



            //saves questions answers for a user
            foreach($questions as $key => $value)
            {

                //Auth::guard('web')->user()->activities_answers()->synch($value->id, ['answer' => 'ffffff']);
                Auth::guard('web')->user()->activities_answers()->sync([
                            28 => ['answer' => 'ffffssf1'],
                            29 => ['answer' => 'ffffff2'],
                            30 => ['answer' => 'ffffff3'],
                            ]

                        );

            }
 */
        } else {
            abort(404);
        }

    }


    public function render()
    {
        return view('livewire.frontend.activity-feedback-form');
    }
}
