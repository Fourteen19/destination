<?php

namespace App\Services\Frontend;

use App\Models\SelfAssessment;



Class selfAssessmentService
{

    protected $selfAssessment;

    /**
     * Takes a year as param,
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
    public function createSelfAssessment($year = NULL)
    {

        SelfAssessment::create([
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
     * Updates the self assessment in DB
     *
     * @param  Array $careerScores
     * @return void
     */
    public function saveCareerReadinessScores(Array $careerScores)
    {

        //gets the average of answers
        $careerReadinessScore = $this->calculatesCareerReadinessAverage($careerScores);

        //updates the current self assessment
        return auth()->user()->getSelfAssessment()->update([
            'career_readiness_score_1' => $careerScores[1],
            'career_readiness_score_2' => $careerScores[2],
            'career_readiness_score_3' => $careerScores[3],
            'career_readiness_score_4' => $careerScores[4],
            'career_readiness_score_5' => $careerScores[5],
            'career_readiness_average' => $careerReadinessScore,
        ]);

    }



    /***************** SUBJECTS ***************************/


    public function getAllocatedSubjectTags(){

        //gets the current assessment for the user
        $this->selfAssessment = $this->getSelfAssessment();

        return $this->selfAssessment->tagsWithType('subject'); // returns a collection
    }



    /**
     * gives a score to a type 1 answer
     * converts the Text answer to a numeric score
     *
     * @param  String $score
     * @return void
     */
    public function getSubjectScore(String $answer)
    {

        if ($answer == 'I like it') {
            $score = 5;
        } elseif ($answer == 'I dont mind it') {
            $score = 3;
        } elseif ($answer == 'Not for me') {
            $score = 0;
        } elseif ($answer == 'Not applicable') {
            $score = 0;
        } else {
            $score = 0;
        }

        return $score;

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

        $allocateSubjects = [];

        //if a `subject` tag needs assigning
        if (count($subjects) > 0)
        {

            foreach ($subjects as $key => $item) {

                $allocateSubjects[] = $key;
            }

            //tags the assessment
            $this->selfAssessment->syncTagsWithType($allocateSubjects, 'subject');

        // else remove all `subject` tags
        } else {

            //remove all `subject` tags from the assessment
            $this->selfAssessment->syncTagsWithType([], 'subject');
        }

    }




}
