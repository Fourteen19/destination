<?php

namespace App\Services\Frontend;

use App\Models\User;
use App\Models\SystemTag;
use Illuminate\Support\Arr;
use App\Models\SelfAssessment;
use Illuminate\Support\Facades\DB;



Class selfAssessmentService
{

    protected $selfAssessment;



    public function __construct(SelfAssessment $selfAssessment = NULL)
    {

        $this->selfAssessment = NULL;

        $this->articlesPanelService = $articlesPanelService;

    }


    /**
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
            $this->selfAssessment = $this->createSelfAssessmentForUser($user, $year = NULL);

        }

        return $this->selfAssessment;
    }



    /**
     * creates a self assessment for a specific user / year
     *
     * @param  mixed $year
     * @return App\Models\SelfAssessment $selfAssessment
     */
    public function getSelfAssessment($year = NULL)
    {

        //if no year is provided, the function falls back on the year the user is currently in
        $this->selfAssessment = auth()->user()->getSelfAssessment($year);

        //if no self-assessment has been found
        if ($this->selfAssessment == NULL)
        {
            //create
            $this->selfAssessment = $this->createSelfAssessment($year = NULL);
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

        return SelfAssessment::create([
                'user_id' => $user->id,
                'year' => $user->school_year,
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

        return SelfAssessment::create([
                'user_id' => auth()->user()->id,
                'year' => auth()->user()->school_year,
                ]);

    }



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

        return $this->saveCareerReadinessScores($careerScores);

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
     * gets carrer live tags
     *
     * @return void
     */
    public function getCareerReadinessTags(){

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
        return auth()->user()->getSelfAssessment()->update([
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


    public function getAllocatedSubjectTags(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        //returns Live tags with type
        return $this->selfAssessment->tagsWithType('subject'); // returns a collection of live tags of type 'route'

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
     * gives a score to an answer
     * converts the Text answer to a numeric score
     *
     * @param  String $score
     * @return void
     */
    public function getSubjectScore(String $answer)
    {

        if ($answer == 'I like it') {
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

        return $data;

    }



    /**
     * Allocates `subject` tags to a self assessment
     *
     * @param  mixed $subjects
     * @return void
     */
    public function AllocateSubjectTags(Array $subjects){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        $formData = [];

        //if a `subject` tag has been given a value in the form
        if (count($subjects) > 0)
        {
            //loops through the form answers and compiles the data we need to save in the DB
            foreach($subjects as $key => $value){
                $formData[$key] = $this->getSubjectScore($value);
            }

            //save the allocations
            $this->selfAssessment->compileSubjectData($formData, 'subject');

        // else remove all `subject` tags
        } else {

            //remove all `subject` tags from the assessment
            $this->selfAssessment->syncTagsWithType([], 'subject');
        }

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
            foreach($subjects as $key => $value){
                $formData[$key] = $this->getSubjectScore($value);
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

            //tags the assessment and gives each tag a score of 5
            $this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'route');

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

            //tags the assessment and gives each tag a score of 5
            $selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'route');

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

            //tags the assessment and gives each tag a score of 5
            $this->selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'sector');

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

            //tags the assessment and gives each tag a score of 5
            $selfAssessment->syncTagsWithDefaultScoreWithType($tagsIds->toArray(), $defaultScore = 5, 'sector');

        // else remove all `subject` tags
        } else {

            //remove all `sector` tags from the assessment
            $selfAssessment->syncTagsWithType([], 'sector');
        }

    }

}
