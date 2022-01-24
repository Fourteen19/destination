<?php

namespace App\Services\Frontend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SystemTag;
use App\Models\SelfAssessment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


Class SelfAssessmentService
{

    protected $selfAssessment;


    /***
     * creates a self assessment for a specific user / year
     *
     * @param  mixed $year
     * @return App\Models\SelfAssessment $selfAssessment
     */
    public function getSelfAssessmentForUser(User $user, $year = NULL)
    {

        //if no year is provided, the function falls back on the year the user is currently in
        $this->selfAssessment = $user->getSelfAssessment($year);

        //if no self-assessment has been found
        if ($this->selfAssessment == NULL)
        {
            //create
            $this->selfAssessment = $this->createSelfAssessmentForUser($user, $year);
        }

        return $this->selfAssessment;
    }



    /***
     * get self assessment for a specific user / year
     *
     * @param  mixed $year
     * @return App\Models\SelfAssessment $selfAssessment
     */
    public function getSelfAssessmentCareerReadinessForUser(User $user, $year = NULL)
    {

        $selfAssessment = $user->getSelfAssessment($year);

        $tmpAssessment = [];

        if ($selfAssessment)
        {
            $tmpAssessment['career_readiness'] = $this->getCareerReadinessData($selfAssessment);
        } else {
            $tmpAssessment= NULL;
        }

        return $tmpAssessment;
    }



    /**
     * getUserSelfAssessmentDataForUser
     * gets the career readiness data
     * as well as the full assessment itself
     *
     * @param  mixed $user
     * @param  mixed $year
     * @return void
     */
    public function getUserSelfAssessmentDataForUser(User $user, $year = NULL){

        $selfAssessment = $user->getSelfAssessment($year);

        $tmpAssessment = [];

        if ($selfAssessment)
        {
            $tmpAssessment['career_readiness'] = $this->getCareerReadinessData($selfAssessment);
            $tmpAssessment['self_assessment'] = $selfAssessment;
        } else {
            $tmpAssessment= NULL;
        }

        return $tmpAssessment;


    }



    /**
     * getCareerReadinessData
     * Return array of data containing the details of the career readiness for a specific assessment
     *
     * @param  mixed $assessment
     * @return void
     */
    public function getCareerReadinessData(SelfAssessment $assessment)
    {
        //Careers Readiness
        $tmpAssessment = [];

        $tmpAssessment['average'] = $assessment->career_readiness_average;

        for($i=1;$i<=5;$i++)
        {
            $tmpAssessment['q'.$i]['score'] = $score = $assessment->{'career_readiness_score_'.$i};
            if ($i<5)
            {
                $tmpAssessment['q'.$i]['statement'] = $this->getCareerReadinessQuestionType1Statement($score);
            } else {
                $tmpAssessment['q'.$i]['statement'] = $this->getCareerReadinessQuestionType2Statement($score);
            }
        }

        return $tmpAssessment;

    }



    /**
     * creates a self assessment for the current user
     *
     * @param  mixed $year
     * @return App\Models\SelfAssessment $selfAssessment
     */
    public function getSelfAssessment($year = NULL)
    {

        if (!$this->selfAssessment)
        {
            //if no year is provided, the function falls back on the year the user is currently in
            $this->selfAssessment = auth()->user()->getSelfAssessment($year);
        }

        //if no self-assessment has been found
        if ($this->selfAssessment == NULL)
        {

            //create
            $this->selfAssessment = $this->createSelfAssessment($year);
        }

        return $this->selfAssessment;
    }




    /**
     * Creates a new self assessment for the year provided
     *
     * @param  mixed $year
     * @return App\Models\SelfAssessment $selfAssessment
     */
    public function createSelfAssessmentForUser(User $user, $year = NULL)
    {

        if ($year == NULL)
        {
            $year = $user->school_year;
        }

        return SelfAssessment::create([
                'user_id' => $user->id,
                'year' => $year,
                ]);

    }



    /**
     * Creates a new self assessment for the year provided
     *
     * @param  mixed $year
     * @return App\Models\SelfAssessment $selfAssessment
     */
    public function createSelfAssessment($year = NULL)
    {

        if ($year == NULL)
        {
            $year = auth()->user()->school_year;
        }

        $found = False;
        while (($year >= 7) && ($found == False))
        {

            //search for an earlier self assessment
            $oldSelfAssessment = auth()->user()->getSelfAssessment($year);

            //if found
            if ($oldSelfAssessment)
            {
                $found = True;
            } else {
                $year = $year - 1;
            }

        }


        //if a previous self assessment was found
        if ($found)
        {
            //we duplicate the assessment and its relations
            $selfAssessment = $this->duplicateSelfAssessment($oldSelfAssessment);

        } else {

            $selfAssessment = $this->createNewSelfAssessment();

        }

        return $selfAssessment;

    }





    public function createNewSelfAssessment()
    {

        DB::beginTransaction();

        try
        {

            $selfAssessment = SelfAssessment::create([
                'user_id' => auth()->user()->id,
                'year' => auth()->user()->school_year,
                ]);

            DB::commit();

            return $selfAssessment;

        } catch (\exception $e) {

            Log::error($e);

            DB::rollback();

            return false;

        }

    }


    /**
     * duplicateSelfAssessment
     * duplicates an asseessment and its relations to tags, including its scores
     *
     * @return void
     */
    public function duplicateSelfAssessment($oldSelfAssessment)
    {

        DB::beginTransaction();

        try
        {

            $newSelfAssessment = $oldSelfAssessment->replicate();
            $newSelfAssessment->year = Auth::guard('web')->user()->school_year;
            $newSelfAssessment->created_at = Carbon::now();
            $newSelfAssessment->completed = 'N';
            $newSelfAssessment->save();

            foreach($oldSelfAssessment->tags as $tag)
            {
                $extra_attributes = array_except($tag->pivot->getAttributes(), $tag->pivot->getForeignKey());

                $newSelfAssessment->tags()->attach($tag, $extra_attributes);

            }

            DB::commit();

            return $newSelfAssessment;

        } catch (\exception $e) {

            Log::error($e);

            DB::rollback();

            return false;

        }
        //dd($newSelfAssessment);

    }


    /**
     * checkIfCurrentAssessmentIsComplete
     * we check if the current users self assessment is complete
     * and if so, set the "completed" property of the self assessment model
     *
     * @return void
     */
    public function checkIfCurrentAssessmentIsComplete()
    {

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();
        $incomplete = 0;

        //Only if the user is of type `user`
        if (Auth::guard('web')->user()->type == 'user'){

            if ($this->selfAssessment->career_readiness_average == 0)
            {
                $incomplete = 1;

            } else {

                $tags = ['subject', 'sector', 'route'];

                $i = 0;
                while ( ($i < count($tags)) && ($incomplete == 0) )
                {

                    $selfAssessmentTags = $this->getAllocatedTags($tags[$i]);

                    if (count($selfAssessmentTags) == 0)
                    {
                        $incomplete = 1;
                    }
                    $i++;
                }

            }

        }



        if ($incomplete == 1){
            return False;
        } else {

            $this->selfAssessment->setToCompleted();

            return True;
        }


    }



    /**
     * checkCurrentAssessmentStatus
     *
     * @return void
     */
    public function checkCurrentAssessmentStatus()
    {

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();
//dd($this->selfAssessment);
        if ($this->selfAssessment->completed == "Y")
        {
            return True;
        } else {
            return False;
        }

    }


    /**
     * getAllocatedTags
     * gets the allocated tags of the current assessment
     *
     * @param  mixed $tagType
     * @return void
     */
    public function getAllocatedTags($tagType)
    {

        if (empty($this->selfAssessment))
        {

            //gets the current assessment for the user
            $this->selfAssessment = $this->getSelfAssessment();

        }

        //returns Live tags with type
        return $this->selfAssessment->tagsWithType($tagType); // returns a collection of live tags of type $tagType

    }



    /**
     * updateTagsScore
     * update the datbase
     *
     * @param  mixed $tagsToupdate
     * @param  mixed $selfAssessmentId
     * @param  mixed $scoreToAdd
     * @return void
     */
    public function updateTagsScore(Array $tagsToupdate=[], Int $selfAssessmentId=0, Int $scoreToAdd=0)
    {

        DB::table('taggables')
        ->whereIn('tag_id', $tagsToupdate) //Array of tags
        ->where('taggable_type', 'App\Models\SelfAssessment')
        ->where('taggable_id', $selfAssessmentId) // assessment id
        ->update(['score' => DB::raw('score + '.$scoreToAdd) ]);

    }



    ////////////////////////


    /**
     * Receives data from the career readiness form
     *
     *
     * @param  mixed $careerReadinessData
     * @return void
     */
    public function compileAndSaveCareerReadinessScores(Array $careerReadinessData)
    {

        $careerScores = $this->compileCareerReadiness($careerReadinessData);

        $res = $this->saveCareerReadinessScores($careerScores);

        $this->checkIfCurrentAssessmentIsComplete();

        return $res;

    }



    /**
     * gives statement bsaed on type 1 answer
     * converts the Text answer to a numeric score
     * Used in admin "view user data"
     *
     * @param  String $score
     * @return void
     */
    public function getCareerReadinessQuestionType1Statement(Int $score)
    {

        if ($score == 5) {
            $statement = 'Strongly agree';
        } elseif ($score == 4) {
            $statement = 'Agree';
        } elseif ($score == 3) {
            $statement = 'Neither agree or disagree';
        } elseif ($score == 2) {
            $statement = 'Disagree';
        } elseif ($score == 1) {
            $statement = 'Strongly disagree';
        } else {
            $statement = '';
        }

        return $statement;

    }



    /**
     * gives a score to a type 1 answer
     * converts the Text answer to a numeric score
     *
     * @param  String $score
     * @return void
     */
    public function getCareerReadinessQuestionType1Score(String $answer)
    {

        if ($answer == 'Strongly agree') {
            $score = 5;
        } elseif ($answer == 'Agree') {
            $score = 4;
        } elseif ($answer == 'Neither agree or disagree') {
            $score = 3;
        } elseif ($answer == 'Disagree') {
            $score = 2;
        } elseif ($answer == 'Strongly disagree') {
            $score = 1;
        } else {
            $score = 0;
        }

        return $score;

    }



    /**
     * gives statement bsaed on type 1 answer
     * converts the Text answer to a numeric score
     * Used in admin "view user data"
     *
     * @param  String $score
     * @return void
     */
    public function getCareerReadinessQuestionType2Statement(Int $score)
    {

        if ($score == 1) {
            $statement = 'Strongly agree';
        } elseif ($score == 2) {
            $statement = 'Agree';
        } elseif ($score == 3) {
            $statement = 'Neither agree or disagree';
        } elseif ($score == 4) {
            $statement = 'Disagree';
        } elseif ($score == 5) {
            $statement = 'Strongly disagree';
        } else {
            $statement = '';
        }

        return $statement;

    }


    /**
     * gives a score to a type 2 answer
     * converts the Text answer to a numeric score
     *
     * @param  String $score
     * @return void
     */
    public function getCareerReadinessQuestionType2Score(String $answer)
    {

        if ($answer == 'Strongly agree') {
            $score = 1;
        } elseif ($answer == 'Agree') {
            $score = 2;
        } elseif ($answer == 'Neither agree or disagree') {
            $score = 3;
        } elseif ($answer == 'Disagree') {
            $score = 4;
        } elseif ($answer == 'Strongly disagree') {
            $score = 5;
        } else {
            $score = 0;
        }

        return $score;

    }



    /**
     * compile the answers from Text to Integer scores
     *
     * @param  Array $careerReadinessData
     * @return void
     */
    public function compileCareerReadiness(Array $careerReadinessData)
    {

        $careerScores = [];

        $iteration = 0;
        foreach ($careerReadinessData as $value) {

            //for question 1, 2, 3, 4
            if ($iteration < 4) {

                $score = $this->getCareerReadinessQuestionType1Score($value);

                //for the last question
            } else {

                $score = $this->getCareerReadinessQuestionType2Score($value);
            }

            $careerScores[$iteration + 1] = $score;

            $iteration++;
        }

        return $careerScores;
    }






    /**
     * calculates the average of the readiness score
     *
     * @param  mixed $careerReadinessData
     * @return void
     */
    public function calculatesCareerReadinessAverage(Array $careerReadinessData)
    {

        //if no answer, we exit as we cannot divide by 0
        if (count($careerReadinessData) == 0){
            return 0;
        }

        //adds all the answers of the career readiness quesitons
        $careerReadinessScore = 0;

        foreach($careerReadinessData as $key => $value)
        {
            $careerReadinessScore += $value;
        }

        //calculates the average career readiness score
        return $careerReadinessScore = $careerReadinessScore / count($careerReadinessData);

    }


    /**
     * Determines the tag based on the score
     *
     * @param  mixed $careerReadinessScore
     * @return void
     */
    public function getReadinessTag($careerReadinessScore){

        if ($careerReadinessScore < 2){
            $tag = '1-2';
        } elseif ($careerReadinessScore < 3){
            $tag = '2-3';
        } elseif ($careerReadinessScore < 4){
            $tag = '3-4';
        } elseif ($careerReadinessScore < 5){
            $tag = '4-5';
        } else {
            $tag = '1-2';
        }

        return $tag;
    }



    /**
     * gets career live tags
     *
     * @return void
     */
    public function getCareerReadinessTags(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        return $this->selfAssessment->tagsWithType('career_readiness'); // returns a collection of live tags

    }



    /**
     * Updates the self assessment in DB
     *
     * @param  Array $careerScores
     * @return void
     */
    public function saveCareerReadinessScores(Array $careerScores)
    {

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //gets the average of answers
        $careerReadinessAverage = $this->calculatesCareerReadinessAverage($careerScores);

        $careerReadinessTag = $this->getReadinessTag($careerReadinessAverage);

        //assign tag to assessment
        $this->selfAssessment->syncTagsWithType([$careerReadinessTag], 'career_readiness');

        //updates the current self assessment
        return $this->selfAssessment->update([
            'career_readiness_score_1' => $careerScores[1],
            'career_readiness_score_2' => $careerScores[2],
            'career_readiness_score_3' => $careerScores[3],
            'career_readiness_score_4' => $careerScores[4],
            'career_readiness_score_5' => $careerScores[5],
            'career_readiness_average' => $careerReadinessAverage,
        ]);

    }



    /***************** SUBJECTS ***************************/


    /**
     * gets live tags
     *
     * @return void
     */
    public function getSubjectTags(){

        return $this->selfAssessment->tagsWithType('subject'); // returns a collection of live tags

    }


    /**
     * getAllocatedSubjectTags
     * used in the assessment
     *
     * @return void
     */
    public function getAllocatedSubjectTags(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //returns Live tags with type
        return $this->selfAssessment->tagsWithType('subject'); // returns a collection of live tags of type 'route'

    }




    /**
     * getAllocatedSubjectTags
     * compiles the subject tags and only keep the ones with a score
     * used outside the assessment
     *
     * @return void
     */
    public function getCompiledAllocatedSubjectTags(){

        $selfAssessmentSubjectTags = app('selfAssessmentSingleton')->getAllocatedSubjectTags();

        //if the self assessment has a `subject` tags
        if ($selfAssessmentSubjectTags != null)
        {

            //only keeps `subject` tagged with score > 0
            $sortedSubjectTags = $selfAssessmentSubjectTags->filter(function ($tag, $key) {
                if (Auth::guard('web')->user()->type == "user")
                {
                    return $tag->pivot->score > 0;
                } else {
                    return True;
                }
            });

            //sort the tags by score
            $sortedSubjectTags = $sortedSubjectTags->sortByDesc(function ($tag, $key) {
                if (Auth::guard('web')->user()->type == "user")
                {
                    return $tag->pivot->score;
                } else {
                    return True;
                }
            })->pluck('name', 'id')->toArray();



            //creates a new variables holding the subjects and the related articles
            foreach($sortedSubjectTags as $key => $value)
            {
                $sortedSubjectTagsArray[$key] = $value;
            }

            return $sortedSubjectTagsArray;

        }

        return [];

    }

    public function getAllocatedSubjectTagsAnswers(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //gets the subjects tags with scores
        $tags = $this->getSubjectTags();

        //compiles the scores in an array
        $answers = [];
        foreach($tags as $item){
            $answers[$item->id] = $item->pivot->assessment_answer;
        }

        return $answers;

    }




    /**
     * getAllocatedSubjectTagsAnswersAndScore
     * gets the self assessment  answer and the aggregating score for the tags
     *
     * @return void
     */
    public function getAllocatedSubjectTagsAnswersAndScore(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //gets the subjects tags with scores
        $tags = $this->getSubjectTags();

        //compiles the scores in an array
        $answers = [];
        foreach($tags as $item){
            $answers[$item->id]['answer'] = $item->pivot->assessment_answer;
            $answers[$item->id]['score'] = $item->pivot->score;
        }

        return $answers;

    }



    /**
     * getAllocatedSubjectTagsSelfAssessmentRadioScores
     * return the values required by the self assessment subject page
     * it is done using the aggregated score
     *
     * @return void
     */
    public function getAllocatedSubjectTagsSelfAssessmentRadioScores()
    {
        //gets the answers and the scores of the tags
        $subjectsScores = $this->getAllocatedSubjectTagsAnswersAndScore();

        $adjustedSubjectsScores = [];
        foreach($subjectsScores as $key => $value)
        {

            if ($value['score'] >= 5)
            {
                $adjustedSubjectsScores[$key] = 1; //I like it
            } elseif ($value['score'] > 0) {
                $adjustedSubjectsScores[$key] = 2; // 50/50
            } elseif ($value['score'] <= 0) {
                $adjustedSubjectsScores[$key] = $value['answer'];
            }
        }

        return $adjustedSubjectsScores;
    }




     /**
      * getSubjectScore
      *
      * @param  mixed $newAnswer    answer select in the assessment
      * @param  mixed $currentValue    answer currently held in the database
      * @return void
      */
    public function getSubjectScore(String $newAnswer, Array $currentDbValue)
    {

        if ($newAnswer == 'I like it') {

            //if the tag score in the DB is < 5
            if ($currentDbValue['score'] < 5)
            {
                $data = ['answer' => 1, 'score' => 5]; //bump the score to 5
            } else {
                $data = ['answer' => 1, 'score' => $currentDbValue['score'] ]; //keep the current DB score as the tag has been used reading articles
            }

        } elseif ($newAnswer == 'I dont mind it') {
            $data = ['answer' => 2, 'score' => 3];
        } elseif ($newAnswer == 'Not for me') {
            $data = ['answer' => 3, 'score' => 0];
        } elseif ($newAnswer == 'Not applicable') {
            $data = ['answer' => 4, 'score' => 0];
        } else {
            $data = ['answer' => 4, 'score' => 0];
        }

        return $data;

        /* if ($answer == 'I like it') {
            $data = ['answer' => 1, 'score' => 5];
        } elseif ($answer == 'I dont mind it') {
            $data = ['answer' => 2, 'score' => 3];
        } elseif ($answer == 'Not for me') {
            $data = ['answer' => 3, 'score' => 0];
        } elseif ($answer == 'Not applicable') {
            $data = ['answer' => 4, 'score' => 0];
        } else {
            $data = ['answer' => 4, 'score' => 0];
        }

        return $data; */






    }



    /**
     * Allocates `subject` tags to a self assessment
     *
     * @param  mixed $subjects
     * @return void
     */
    public function allocateSubjectTags(Array $subjects){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        $formData = [];
        //dd($this->selfAssessment->tags->firstWhere('name', 'Maths')->where('type', 'subject')->pivot->toArray());
        //if a `subject` tag has been given a value in the form
        if (count($subjects) > 0)
        {
            //loops through the form answers and compiles the data we need to save in the DB
            foreach($subjects as $key => $value)
            {

                //fetches from the selfassessment the article subject tag
                $tag = $this->selfAssessment->tags->filter(function ($value_coll, $key_coll) use ($key) {
                    return ($value_coll->live == 'Y') && ($value_coll->name == $key) && ($value_coll->type == 'subject');
                })->first();

                //if the tag is not found, ie. new assessment OR the tag is new
                if (!$tag)
                {

                    $formData[$key] = $this->getSubjectScore($value, //value submitted by form
                                                ['score' => 0] //default value
                                                );
                } else {
                    //calls a function to translate the score based on the user new answer and the score held in the database
                    $formData[$key] = $this->getSubjectScore($value, //value submitted by form
                                                            $tag->pivot->toArray()
                                                            );
                }
            }

            //save the allocations
            $this->selfAssessment->compileSubjectData($formData, 'subject');

            $this->checkIfCurrentAssessmentIsComplete();

        // else remove all `subject` tags
        } else {

            //remove all `subject` tags from the assessment
            $this->selfAssessment->syncTagsWithType([], 'subject');
        }

    }




    public function getAllSubjectTags(){

        //returns Live tags with type
        return SystemTag::select('uuid', 'name')->where('type', 'subject')->where('live', 'Y')->orderBy('name', 'ASC')->get();
    }




    /**
     * Allocates `subject` tags to a self assessment for a selfassessment
     *
     * @param  mixed $subjects
     * @return void
     */
    public function allocateSubjectTagsForAssessment(selfAssessment $selfAssessment, Array $subjects){

        //gets the current assessment for the user
        $this->selfAssessment = $selfAssessment;

        $formData = [];

        //if a `subject` tag has been given a value in the form
        if (count($subjects) > 0)
        {

            //loops through the form answers and compiles the data we need to save in the DB
            foreach($subjects as $key => $value)
            {

                //fetches from the selfassessment the article subject tag
                $tag = $this->selfAssessment->tags->filter(function ($value_coll, $key_coll) use ($key) {
                    return ($value_coll->live == 'Y') && ($value_coll->name == $key) && ($value_coll->type == 'subject');
                })->first();

                //if the tag is not found, ie. new assessment OR the tag is new
                if (!$tag)
                {

                    $formData[$key] = $this->getSubjectScore($value, //value submitted by form
                                                ['score' => 0] //default value
                                                );
                } else {
                    //calls a function to translate the score based on the user new answer and the score held in the database
                    $formData[$key] = $this->getSubjectScore($value, //value submitted by form
                                                            $tag->pivot->toArray()
                                                            );
                }
            }

            //save the allocations
            $this->selfAssessment->compileSubjectData($formData, 'subject');

        // else remove all `subject` tags
        } else {

            //remove all `subject` tags from the assessment
            $this->selfAssessment->syncTagsWithType([], 'subject');
        }

    }








    /***************** ROUTES ***************************/


    /**
     * Returns a collection of `Route` tags associated with the self assessment
     *
     * @return void
     */
    public function getAllocatedRouteTags(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //returns Live tags with type
        return $this->selfAssessment->tagsWithType('route'); // returns a collection of live tags of type 'route'
    }


    /**
    * Returns a collection of `Route` tags associated with the self assessment
     *
     * @return void
     */
    public function getAllocatedRouteTagsName(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        return $this->selfAssessment->tagsWithType('route')->pluck('name'); // returns a collection of live tags
    }


    public function getAllRouteTags(){

        //returns Live tags with type
        return SystemTag::select('uuid', 'name')->where('type', 'route')->where('live', 'Y')->orderBy('name', 'ASC')->get();
    }


    /**
     * Allocates `route` tags to a self assessment
     *
     * @param  Array $routes  data comes from the form
     * @return void
     */
    public function AllocateRouteTags(Array $routes){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //if a `route` tag needs assigning
        if (count($routes) > 0)
        {
            //return the ids of the `route` tags
            $tagsIds = collect(SystemTag::findOrCreate($routes, 'route'))->pluck('id');


            $defaultScores = array_fill(0, count($tagsIds), 0);

            foreach($tagsIds as $key => $tagsId)
            {

                //fetches from the self-assessment the article route tag
                $tag = $this->selfAssessment->tags->filter(function ($value_coll, $key_coll) use ($tagsId) {
                    return ( ($value_coll->live == 'Y') && ($value_coll->id == $tagsId) && ($value_coll->type == 'route') );
                })->first();

                if (!$tag)
                {
                    $defaultScores[$key] = 5;
                } else {
                    $defaultScores[$key] = $tag->pivot->score;
                }

                //tags the assessment and gives each tag a score of 5
                //$selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'route');

            }

            //tags the assessment and gives each tag a score of 5
            $this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScores, 'route');

            $this->checkIfCurrentAssessmentIsComplete();

        // else remove all `route` tags
        } else {

            //remove all `route` tags from the assessment
            $this->selfAssessment->syncTagsWithType([], 'route');
        }

    }



    /**
     * Allocates `route` tags to a self assessment
     *
     * @param  Array $routes  data comes from the form
     * @return void
     */
    public function AllocateRouteTagsForAssessment(selfAssessment $selfAssessment, Array $routes){

        //if a `route` tag needs assigning
        if (count($routes) > 0)
        {
            //return the ids of the `route` tags
            $tagsIds = collect(SystemTag::findOrCreate($routes, 'route'))->pluck('id');

            $defaultScores = array_fill(0, count($tagsIds), 0);

            foreach($tagsIds as $key => $tagsId)
           {

               //fetches from the self-assessment the article route tag
               $tag = $this->selfAssessment->tags->filter(function ($value_coll, $key_coll) use ($tagsId) {
                   return ( ($value_coll->live == 'Y') && ($value_coll->id == $tagsId) && ($value_coll->type == 'route') );
               })->first();

               if (!$tag)
               {
                   $defaultScores[] = 5;
               } else {
                   $defaultScores[] = $tag->pivot->score;
               }

               //tags the assessment and gives each tag a score of 5
               //$selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'route');

           }

           //tags the assessment and gives each tag a score of 5
           $this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScores, 'route');

        // else remove all `route` tags
        } else {

            //remove all `route` tags from the assessment
            $selfAssessment->syncTagsWithType([], 'route');
        }

    }



    /***************** SECTORS ***************************/


    /**
    * Returns a collection of `Secor` tags associated with the self assessment
     *
     * @return void
     */
    public function getAllocatedSectorTags(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        return $this->selfAssessment->tagsWithType('sector'); // returns a collection of live tags
    }



    /**
    * Returns a collection of `Secor` tags associated with the self assessment
     *
     * @return void
     */
    public function getAllocatedSectorTagsName(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        return $this->selfAssessment->tagsWithType('sector')->pluck('name'); // returns a collection of live tags
    }


    public function getAllSectorTags(){

        //returns Live tags with type
        return SystemTag::select('uuid', 'name')->where('type', 'sector')->where('live', 'Y')->orderBy('name', 'ASC')->get();
    }


    /**
     * Allocates `sector` tags to a self assessment
     *
     * @param  mixed $sectors
     * @return void
     */
    public function AllocateSectorTags(Array $sectors){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //if a `sector` tag needs assigning
        if (count($sectors) > 0)
        {

            //return the ids of the `sector` tags
            $tagsIds = collect(SystemTag::findOrCreate($sectors, 'sector'))->pluck('id');

            $defaultScores = array_fill(0, count($tagsIds), 0);

            foreach($tagsIds as $key => $tagsId)
            {

               //fetches from the self-assessment the article route tag
               $tag = $this->selfAssessment->tags->filter(function ($value_coll, $key_coll) use ($tagsId) {
                   return ( ($value_coll->live == 'Y') && ($value_coll->id == $tagsId) && ($value_coll->type == 'sector') );
               })->first();

               if (!$tag)
               {
                   $defaultScores[$key] = 5;
               } else {
                   $defaultScores[$key] = $tag->pivot->score;
               }

               //tags the assessment and gives each tag a score of 5
               //$this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'sector');

            }

            $this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScores, 'sector');

            $this->checkIfCurrentAssessmentIsComplete();

        // else remove all `subject` tags
        } else {

            //remove all `sector` tags from the assessment
            $this->selfAssessment->syncTagsWithType([], 'sector');
        }

    }




    /**
     * Allocates `sector` tags to a self assessment
     *
     * @param  mixed $sectors
     * @return void
     */
    public function AllocateSectorTagsForAssessment(selfAssessment $selfAssessment,Array $sectors){

        //if a `sector` tag needs assigning
        if (count($sectors) > 0)
        {

            //return the ids of the `sector` tags
            $tagsIds = collect(SystemTag::findOrCreate($sectors, 'sector'))->pluck('id');

            $defaultScores = array_fill(0, count($tagsIds), 0);

            foreach($tagsIds as $key => $tagsId)
            {

               //fetches from the self-assessment the article route tag
               $tag = $this->selfAssessment->tags->filter(function ($value_coll, $key_coll) use ($tagsId) {
                   return ( ($value_coll->live == 'Y') && ($value_coll->id == $tagsId) && ($value_coll->type == 'sector') );
               })->first();

               if (!$tag)
               {
                   $defaultScores[] = 5;
               } else {
                   $defaultScores[] = $tag->pivot->score;
               }

                //tags the assessment and gives each tag a score of 5
                //$selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'sector');

            }

            $this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScores, 'sector');

        // else remove all `subject` tags
        } else {

            //remove all `sector` tags from the assessment
            $selfAssessment->syncTagsWithType([], 'sector');
        }

    }



    /**
     * clearSlotfromDashboard
     * reset all dashboard slot to NULL
     *
     * @param  mixed $slotId
     * @param  mixed $type
     * @return void
     */
    public function clearAllSlotfromDashboard()
    {

        //clears all dashboard slots
        for($i=1;$i<=6;$i++)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot($i, '');
        }

    }



    /**
     * clearSlotfromDashboard
     * reset all "something different" slot to NULL
     *
     * @param  mixed $slotId
     * @param  mixed $type
     * @return void
     */
    public function clearAllSlotfromSomethingDifferentPanel()
    {

        //clears all 'something different' slots
        for($i=1;$i<=3;$i++)
        {
            Auth::guard('web')->user()->clearUserDashboardSlot($i, 'sd_');
        }

    }


}
