<?php

namespace App\Services\Frontend;

use App\Models\PageLive;

Class ContentService{


    /**
     * getHomepageDetails
     * return the homepage. Slection ids done by the slug
     *
     * @return void
     */
    public function getHomepageDetails()
    {
        return PageLive::where('slug', '=', 'home')->get()->first();
    }


}
