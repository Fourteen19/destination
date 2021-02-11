<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use App\Services\Frontend\SomethingDifferentService;

class SomethingDifferentComposer
{

    protected $readItAgainService;

    public function __construct(SomethingDifferentService $somethingDifferentService)
    {
        $this->somethingDifferentService = $somethingDifferentService;
    }


    public function compose(View $view)
    {

        $articles = $this->somethingDifferentService->getSomethingDifferentArticlesSummary();

        $displayArticles = (count($articles) == 3) ? 'Y' : 'N';

        $view->with('displaySomethingDifferentArticles', $displayArticles);

        if ($displayArticles == 'Y')
        {
            $view->with('somethingDifferentArticles', $articles);
        }

    }


}
