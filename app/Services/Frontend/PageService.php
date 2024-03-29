<?php

namespace App\Services\Frontend;


use App\Models\PageLive;
use App\Models\PageHomepageLive;

Class PageService{


    /**
     * getHomepageDetails
     * return the homepage. Slection ids done by the slug
     *
     * @return void
     */
    public function getHomepageDetails()
    {
        return PageLive::select('id', 'title', 'pageable_type', 'pageable_id' )->with('media')->where('slug', '=', 'home')->get()->first();
    }


    /**
     * getLiveSummaryPageById
     *
     * @param  mixed $id
     * @return void
     */
    public function getLiveSummaryPageById($id)
    {
        return PageLive::select('title', 'slug')->where('id', '=', $id)->get()->first();
    }


    /**
     * getFixedLinks
     * gets the pages set with 'display_in_header' set to 'Y'
     *
     * @return void
     */
    public function getFixedLinks()
    {
        return PageLive::select('title', 'slug')->where('display_in_header', '=', 'Y')->get();
    }


    /**
     * getLiveSummaryPageById
     *
     * @param  mixed $id
     * @return void
     */
    public function getLivePageBySlug($slug)
    {
        return PageLive::where('slug', '=', $slug)->get()->first();
    }
}
