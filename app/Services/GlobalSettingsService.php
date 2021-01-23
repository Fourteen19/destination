<?php

namespace App\Services;

use App\Models\GlobalSettings;


Class GlobalSettingsService
{

    public $globalSettings;

    public function __construct()
    {
        //
    }




    public function getGlobalSettings()
    {

        if (empty($this->globalSettings))
        {
            //get data from DB
            $this->globalSettings = GlobalSettings::find(1);
        }

        return $this->globalSettings;

    }




    public function getQuestionTypeList()
    {

        $this->globalSettings = $this->getGlobalSettings();

        if (!empty($this->globalSettings->topic_advisor_questions))
        {
            $questionTypes = json_decode($this->globalSettings->topic_advisor_questions);
            if (!empty($questionTypes->text) > 0)
            {

                foreach($questionTypes->text as $key => $value)
                {
                    $contactAdvisorQuestionTypes[] = $value;
                }
            }

        } else {
            $contactAdvisorQuestionTypes = [];
        }

        return $contactAdvisorQuestionTypes;

    }


    public function getArticleAverageReadingTime()
    {

        $this->globalSettings = $this->getGlobalSettings();

        return $this->globalSettings->articles_wordcount_read_per_minute;

    }

}
