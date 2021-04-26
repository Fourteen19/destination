<?php

namespace App\Http\Livewire\Frontend;

use Ramsey\Uuid\Uuid;
use App\Models\Content;
use Livewire\Component;
use App\Models\ContentLive;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RelatedActivityQuestion;

class ActivityFeedbackForm extends Component
{

    public $uuid;
    public $questionsList = [];
    public $question1;
    public $question2;
    public $question3;

    public function mount($uuid)
    {

        if (Str::isUuid($uuid))
        {

            //gets the live activity content
            $contentLive = ContentLive::where('uuid', $uuid)->first();

            $this->uuid = $uuid;
            $this->questionsList = [];

            //if the activity is not associated to the user
            if (!Auth::guard('web')->user()->activityAnswers( $contentLive->id)->exists() )
            {

                //loads the questions
                $questions = $contentLive->relatedActivityQuestions()->get();

                //builds array
                foreach($questions as $key => $value)
                {
                    $this->questionsList[] = [
                                        'question_id' => $key + 1,
                                        'uuid' => $value['uuid'],
                                        'text' => $value['text'],
                                        'answer' => ''
                                    ];
                }

            } else {

                //loads the questions/amswers for the user
                $questionData = Auth::guard('web')->user()->activityAnswers($contentLive->id)->get();

                //builds array
                foreach($questionData as $key => $value)
                {
                    $this->questionsList[] = [
                                        'question_id' => $key + 1,
                                        'uuid' => $value['uuid'],
                                        'text' => $value['text'],
                                        'answer' => $value->pivot->answer
                                    ];
                }

            }

        } else {
            abort(404);
        }

    }



    /**
     * checkIfFormIsCompleted
     *
     * @return void
     */
    public function checkIfFormIsCompleted()
    {
        $completed = 'N';

        //if all the questions have been completed
        if ( (!empty($this->question1)) && (!empty($this->question2)) && (!empty($this->question3)) )
        {
            $completed = 'Y';
        }

        return $completed;
    }





    public function submit()
    {


        //gets the live activity content
        $contentLive = ContentLive::where('uuid', $this->uuid)->first();

        $completed = $this->checkIfFormIsCompleted();


        //if the user/activity are not already attached
        if (!Auth::guard('web')->user()->user_activities($contentLive->id)->exists() )
        {
            //attach the user/activity
            Auth::guard('web')->user()->user_activities()->attach($contentLive->id, ['completed' => $completed] );

        } else {
            //update the user/activity
            Auth::guard('web')->user()->user_activities()->updateExistingPivot($contentLive->id, ['completed' => $completed] );



        }


        //selects the IDs of the related activity questions
        $questions = DB::table('related_activity_questions')->where('activquestionable_id', $contentLive->id)
                                                            ->where('activquestionable_type', 'App\Models\ContentLive')
                                                            ->select('id')
                                                            ->limit(3)
                                                            ->orderBy('id', 'ASC')
                                                            ->get();


         $answers = [];
        //saves questions/answers for the user
        foreach($questions as $key => $value)
        {
            $questionId = $key + 1;

            //compiles array to be saved in pivot table
            $answers[$value->id] = ['answer' => $this->{'question'.$questionId}];

        }

        //synchronises he pivot table
        Auth::guard('web')->user()->activityAnswers($contentLive->id)->sync($answers);

    }


    public function render()
    {
        return view('livewire.frontend.activity-feedback-form');
    }

}
