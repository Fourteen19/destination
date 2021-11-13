<?php

namespace App\Services\Frontend;

use Request;
use App\Models\Client;
use App\Models\StaticClientContent;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

Class ClientContentSettigsService
{

    protected $pageService;

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }


    public function cacheClientstaticContent($clientId)
    {

        $staticContent = StaticClientContent::find($clientId)->with('media')->first();

        //Cache::put('client:'.$clientId.':static-content', $staticContent);
        Redis::set('client:'.$clientId.':static-content', serialize($staticContent));
    }

    public function getCachedStaticContent()
    {
        //return json_decode(Cache::get('client:'.Session::get('fe_client')['id'].':static-content'));
        //dd( unserialize(Redis::get('client:'.Session::get('fe_client')['id'].':static-content')) );
        return unserialize(Redis::get('client:'.Session::get('fe_client')['id'].':static-content'));
    }


    public function getCachedStaticContentData()
    {
        if (Redis::exists('client:'.Session::get('fe_client')['id'].':static-content'))
        //if (Cache::has('client:'.Session::get('fe_client')['id'].':static-content'))
        {
            $cachedData = $this->getCachedStaticContent();
        } else {
            $cachedData = $this->cacheClientstaticContent(Session::get('fe_client')['id']);
        }



/*
$cachedData = arrayCastRecursive($cachedData);

$post = new StaticClientContent;
$post->fill($cachedData)->media;

dd($post);
*/
/*
        $cachedData = arrayCastRecursive($cachedData);
        $cachedData['media'] = $cachedData['media'][0];
        $model = \Spatie\MediaLibrary\MediaCollections\Models\Media::hydrate($cachedData['media']);
        dd($model);
        dd($cachedData['media']);
//dd($a);
        $e = StaticClientContent::hydrate( $a );
        dd( $e );*/
        //dd($cachedData);

        return $cachedData;

    }


    public function getLoginBoxDetails()
    {

        return $this->getCachedStaticContentData();

        /* $data['id'] = $cachedData->id;
        $data['login_block_heading'] = $cachedData->login_block_heading;
        $data['login_block_body'] = $cachedData->login_block_body;

        return $data; */
        //return StaticClientContent::select('id', 'login_block_heading', 'login_block_body')->with('media')->where('client_id', Session::get('fe_client')['id'] )->get()->first();
    }



    public function getFooterDetails()
    {

        return $this->getCachedStaticContentData();

        /* $data['tel'] = $cachedData->tel;
        $data['email'] = $cachedData->email;
        $data['show_terms'] = $cachedData->show_terms;
        $data['show_privacy'] = $cachedData->show_privacy;
        $data['show_cookies'] = $cachedData->show_cookies;

        return $data; */

/*
        if (Session::get('fe_client'))
        {
            return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('tel', 'email', 'show_terms', 'show_privacy', 'show_cookies')->first()->toArray();

        } else {
            list($subdomain) = explode('.', Request::getHost(), 2);
            $client = Client::where('subdomain', $subdomain)->firstOrFail();
            return $client->staticClientContent()->select('tel', 'email', 'show_terms', 'show_privacy', 'show_cookies')->first()->toArray();
        } */
    }


    public function getLoginIntroText()
    {

        return $this->getCachedStaticContentData();

        /* $data['login_intro'] = $cachedData->login_intro;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('login_intro')->first()->toArray();
    }



    public function getPreFooterBlock()
    {

        /* if (Session::get('fe_client'))
        { */

            $cachedData = $this->getCachedStaticContentData();

            /*
            $data['pre_footer_heading'] = $cachedData->pre_footer_heading;
            $data['pre_footer_body'] = $cachedData->pre_footer_body;
            $data['pre_footer_button_text'] = $cachedData->pre_footer_button_text;
            $data['pre_footer_link'] = $cachedData->pre_footer_link;

            if ($data['pre_footer_link'])
            {
                $preFooterPage = $this->pageService->getLivePageDetailsById($data['pre_footer_link']);
                $data['pre_footer_link_goto'] = $preFooterPage->slug;
            } else {
                $data['pre_footer_link_goto'] = NULL;
            }
            */

            if ($cachedData->pre_footer_link)
            {
                $preFooterPage = $this->pageService->getLivePageDetailsById($cachedData->pre_footer_link);
                $cachedData->pre_footer_link_goto = $preFooterPage->slug;
            } else {
                $cachedData->pre_footer_link_goto = NULL;
            }

//        } else {

            /* list($subdomain) = explode('.', Request::getHost(), 2);
            $client = Client::where('subdomain', $subdomain)->firstOrFail();
            $data = $client->staticClientContent()->select('pre_footer_heading', 'pre_footer_body', 'pre_footer_button_text', 'pre_footer_link')->first();//->toArray();

            if ($data->pre_footer_link)
            {
                $preFooterPage = $this->pageService->getLivePageDetailsById($data->pre_footer_link);
                $data->pre_footer_link_goto = $preFooterPage->slug;
            } else {
                $data->pre_footer_link_goto = NULL;
            } */

//        }

        return $cachedData;
    }


    public function getWelcomeIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['welcome_intro'] = $cachedData->welcome_intro;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('welcome_intro')->first()->toArray();
    }

    public function getCareersIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['careers_intro'] = $cachedData->careers_intro;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('careers_intro')->first()->toArray();
    }


    public function getSubjectsIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['subjects_intro'] = $cachedData->subjects_intro;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('subjects_intro')->first()->toArray();
    }


    public function getRoutesIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['routes_intro'] = $cachedData->routes_intro;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('routes_intro')->first()->toArray();
    }


    public function getSectorsIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['sectors_intro'] = $cachedData->sectors_intro;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('sectors_intro')->first()->toArray();
    }

    public function getAssessmentCompletedIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['assessment_completed_txt'] = $cachedData->assessment_completed_txt;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('assessment_completed_txt')->first()->toArray();
    }

    public function getPreFooterSupportBlock()
    {

        $cachedData = $this->getCachedStaticContentData();

        if ($cachedData->support_block_link)
        {
            $supportFooterPage = $this->pageService->getLivePageDetailsById($cachedData->support_block_link);
            $cachedData->support_block_link_goto = $supportFooterPage->slug;
        } else {
            $cachedData->support_block_link_goto = NULL;
        }

        /* $data['support_block_heading'] = $cachedData->support_block_heading;
        $data['support_block_body'] = $cachedData->support_block_body;
        $data['support_block_button_text'] = $cachedData->support_block_button_text;
        $data['support_block_link'] = $cachedData->support_block_link;


        if ($data['support_block_link'])
        {
            $supportFooterPage = $this->pageService->getLivePageDetailsById($data['support_block_link']);
            $data['support_block_link_goto'] = $supportFooterPage->slug;
        } else {
            $data['support_block_link_goto'] = NULL;
        }

        return $data; */

        return $cachedData;

    }

    public function getLoggedInPrefooter()
    {

        return $this->getCachedStaticContentData();

        /* $data['get_in_right_heading'] = $cachedData->get_in_right_heading;
        $data['get_in_right_body'] = $cachedData->get_in_right_body;
        $data['support_block_button_text'] = $cachedData->support_block_button_text;
        $data['support_block_link'] = $cachedData->support_block_link;

        return $data; */

        //return Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('get_in_right_heading', 'get_in_right_body', 'support_block_button_text', 'support_block_link')->first()->toArray();
    }

    public function getFreeArticlesMessage()
    {

        return $this->getCachedStaticContentData();

        /* $data['free_articles_message'] = $cachedData->free_articles_message;

        return $data; */

        //$data = Client::find(Session::get('fe_client')['id'])->staticClientContent()->select('free_articles_message')->first()->toArray();
        //return $data['free_articles_message'];
    }

    public function getWorkExperienceIntro()
    {

        $cachedData = $this->getCachedStaticContentData();

        if ($cachedData->we_button_link)
        {
            $preFooterPage = $this->pageService->getLivePageDetailsById($cachedData->we_button_link);
            $cachedData->we_button_link_goto = $preFooterPage->slug;
        } else {
            $cachedData->we_button_link_goto = NULL;
        }

        /*
        $data['we_intro'] = $cachedData->we_intro;
        $data['we_button_text'] = $cachedData->we_button_text;
        $data['we_button_link'] = $cachedData->we_button_link;

        if ($data['we_button_link'])
        {
            $preFooterPage = $this->pageService->getLivePageDetailsById($data['we_button_link']);
            $data['we_button_link_goto'] = $preFooterPage->slug;
        } else {
            $data['we_button_link_goto'] = NULL;
        }
 */
        return $cachedData;

/*
        $data = StaticClientContent::select('we_intro', 'we_button_text', 'we_button_link')->where('client_id', Session::get('fe_client')['id'] )->get()->first();

        if ($data['we_button_link'])
        {
            $preFooterPage = $this->pageService->getLivePageDetailsById($data['we_button_link']);
            $data['we_button_link_goto'] = $preFooterPage->slug;
        } else {
            $data['we_button_link_goto'] = NULL;
        }

        return $data;
*/
    }


    public function getNoEventsDetails()
    {

        return $this->getCachedStaticContentData();

        /* $data['no_event'] = $cachedData->no_event;

        return $data; */

        //return StaticClientContent::select('no_event')->where('client_id', Session::get('fe_client')['id'] )->get()->first();
    }

    public function getWorkExperienceDashboardIntro()
    {

        return $this->getCachedStaticContentData();

        /* $data['we_dashboard_intro'] = $cachedData->we_dashboard_intro;

        return $data; */

        /*
        $data = StaticClientContent::select('we_dashboard_intro')->where('client_id', Session::get('fe_client')['id'] )->get()->first();

        return $data;*/
    }

    public function getFeaturedVacancies()
    {

        return $this->getCachedStaticContentData();

        /* $data['featured_vacancy_1'] = $cachedData->featured_vacancy_1;
        $data['featured_vacancy_2'] = $cachedData->featured_vacancy_2;
        $data['featured_vacancy_3'] = $cachedData->featured_vacancy_3;
        $data['featured_vacancy_4'] = $cachedData->featured_vacancy_4; */

/*
        $data = StaticClientContent::select('featured_vacancy_1', 'featured_vacancy_2', 'featured_vacancy_3', 'featured_vacancy_4')
                                    ->where('client_id', Session::get('fe_client')['id'] )
                                    ->first()
                                    ->toArray();

        return $data;
*/
    }

}
