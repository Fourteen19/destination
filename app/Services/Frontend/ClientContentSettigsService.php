<?php

namespace App\Services\Frontend;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

Class ClientContentSettigsService
{

    public function __construct()
    {
        //
    }


    public function getFooterDetails()
    {
        return Session::get('fe_client')->staticClientContent()->select('tel', 'email', 'show_terms', 'show_privacy', 'show_cookies')->first()->toArray();
    }


    public function getLoginIntroText()
    {
        return Session::get('fe_client')->staticClientContent()->select('login_intro')->first()->toArray();
    }


    public function getPreFooterBlock()
    {
        return Session::get('fe_client')->staticClientContent()->select('pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link')->first()->toArray();
    }


    public function getCareersIntro()
    {
        return Session::get('fe_client')->staticClientContent()->select('careers_intro')->first()->toArray();
    }


    public function getSubjectsIntro()
    {
        return Session::get('fe_client')->staticClientContent()->select('subjects_intro')->first()->toArray();
    }


    public function getRoutesIntro()
    {
        return Session::get('fe_client')->staticClientContent()->select('routes_intro')->first()->toArray();
    }


    public function getSectorsIntro()
    {
        return Session::get('fe_client')->staticClientContent()->select('sectors_intro')->first()->toArray();
    }

    public function getAssessmentCompletedIntro()
    {
        return Session::get('fe_client')->staticClientContent()->select('assessment_completed_txt')->first()->toArray();
    }

    public function getPreFooterSupportBlock()
    {
        return Session::get('fe_client')->staticClientContent()->select('support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link')->first()->toArray();
    }

    public function getLoggedInPrefooter()
    {
        return Session::get('fe_client')->staticClientContent()->select('get_in_right_heading', 'get_in_right_body', 'support_block_button_text', 'support_block_link')->first()->toArray();
    }



}
