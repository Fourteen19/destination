<?php

namespace App\Services\Frontend;

use App\Models\Client;
use Request;
use App\Models\StaticClientContent;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Session;

Class ClientContentSettigsService
{

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }


    public function getLoginBoxDetails()
    {
        return StaticClientContent::select('id', 'login_block_heading', 'login_block_body')->with('media')->where('client_id', Session::get('fe_client')->id )->get()->first();
    }

    public function getFooterDetails()
    {//dd(Session::all());
        if (Session::get('fe_client'))
        {
            return Session::get('fe_client')->staticClientContent()->select('tel', 'email', 'show_terms', 'show_privacy', 'show_cookies')->first()->toArray();
        } else {
            list($subdomain) = explode('.', Request::getHost(), 2);
            $client = Client::where('subdomain', $subdomain)->firstOrFail();
            return $client->staticClientContent()->select('tel', 'email', 'show_terms', 'show_privacy', 'show_cookies')->first()->toArray();
        }
    }


    public function getLoginIntroText()
    {
        return Session::get('fe_client')->staticClientContent()->select('login_intro')->first()->toArray();
    }


    public function getPreFooterBlock()
    {
       // dd(Session::get('fe_client'));
        if (Session::get('fe_client'))
        {
            $data = Session::get('fe_client')->staticClientContent()->select('pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link')->first()->toArray();
        } else {
            list($subdomain) = explode('.', Request::getHost(), 2);
            $client = Client::where('subdomain', $subdomain)->firstOrFail();
            $data = $client->staticClientContent()->select('pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link')->first()->toArray();
        }

        if ($data['pre_footer_link'])
        {
            $preFooterPage = $this->pageService->getLivePageDetailsById($data['pre_footer_link']);
            $data['pre_footer_link_goto'] = $preFooterPage->slug;
        } else {
            $data['pre_footer_link_goto'] = NULL;
        }

        return $data;
    }


    public function getWelcomeIntro()
    {
        return Session::get('fe_client')->staticClientContent()->select('welcome_intro')->first()->toArray();
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
        $data = Session::get('fe_client')->staticClientContent()->select('support_block_heading', 'support_block_body', 'support_block_button_text', 'support_block_link')->first()->toArray();

        if ($data['support_block_link'])
        {
            $supportFooterPage = $this->pageService->getLivePageDetailsById($data['support_block_link']);
            $data['support_block_link_goto'] = $supportFooterPage->slug;
        } else {
            $data['support_block_link_goto'] = NULL;
        }

        return $data;
    }

    public function getLoggedInPrefooter()
    {
        return Session::get('fe_client')->staticClientContent()->select('get_in_right_heading', 'get_in_right_body', 'support_block_button_text', 'support_block_link')->first()->toArray();
    }

    public function getFreeArticlesMessage()
    {
        $data = Session::get('fe_client')->staticClientContent()->select('free_articles_message')->first()->toArray();
        return $data['free_articles_message'];
    }

    public function getWorkExperienceIntro()
    {
        $data = StaticClientContent::select('we_intro', 'we_button_text', 'we_button_link')->where('client_id', Session::get('fe_client')->id )->get()->first();

        if ($data['we_button_link'])
        {
            $preFooterPage = $this->pageService->getLivePageDetailsById($data['we_button_link']);
            $data['we_button_link_goto'] = $preFooterPage->slug;
        } else {
            $data['we_button_link_goto'] = NULL;
        }

        return $data;

    }


    public function getWorkExperienceDashboardIntro()
    {
        $data = StaticClientContent::select('we_dashboard_intro')->where('client_id', Session::get('fe_client')->id )->get()->first();

        return $data;
    }

    public function getFeaturedVacancies()
    {
        $data = StaticClientContent::select('featured_vacancy_1', 'featured_vacancy_2', 'featured_vacancy_3', 'featured_vacancy_4')
                                    ->where('client_id', Session::get('fe_client')->id )
                                    ->first()
                                    ->toArray();

        return $data;
    }

}
