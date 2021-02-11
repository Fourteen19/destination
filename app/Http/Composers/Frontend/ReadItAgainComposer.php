<?php

namespace App\Http\Composers\Frontend;

use Illuminate\Contracts\View\View;
use App\Services\Frontend\ReadItAgainService;

class ReadItAgainComposer
{

    protected $readItAgainService;

    public function __construct(ReadItAgainService $readItAgainService)
    {
        $this->readItAgainService = $readItAgainService;
    }


    public function compose(View $view)
    {

        $articles = $this->readItAgainService->getAlreadyReadArticlesSummary();

        $displayArticles = (count($articles) == 3) ? 'Y' : 'N';

        $view->with('displayReadItAgainArticles', $displayArticles);

        if ($displayArticles == 'Y')
        {
            $view->with('readItAgainArticles', $articles);
        }

    }


}
