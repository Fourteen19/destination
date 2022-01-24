<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Frontend\ArticlesService;
use App\Services\Frontend\ActivitiesService;
use Illuminate\Database\Eloquent\Relations\MorphMany;


class ActivityController extends Controller
{

    protected $articlesService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
    public function __construct(ArticlesService $articlesService) {
        $this->articlesService = $articlesService;
    }



    public function suggestedIndex()
    {

        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->canAccessWorkExperience())
        {

            SEOMeta::setTitle("My suggested Activities");

            return view('frontend.pages.activities.suggested.index');

        } else {

            return redirect()->route('frontend.dashboard');

        }

    }



    /**
     * allActivitiesCompleted
     * Displays all activities completed by a user
     *
     * @param  mixed $request
     * @return void
     */
    public function completedIndex()
    {
        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->canAccessWorkExperience())
        {

            SEOMeta::setTitle("My completed Activities");

            return view('frontend.pages.activities.completed.index');

        } else {

            return redirect()->route('frontend.dashboard');

        }
    }


    /**
     * show
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $article
     * @param  mixed $relatedArticlesService
     * @param  mixed $youMightLikeArticlesService
     * @return void
     */
    public function show(String $clientSubdomain, ContentLive $activity)
    {

        //if the user's institution has the "work experience" section enabled
        if (Auth::guard('web')->user()->canAccessWorkExperience())
        {

            SEOMeta::setTitle($activity->title);

            //an article is read - update pivot table, update counters
            $this->articlesService->aUserReadsAnArticle(NULL, $activity);

            return view('frontend.pages.activities.show', ['content' => $activity]);

        } else {

            return redirect()->route('frontend.dashboard');

        }
    }

}
