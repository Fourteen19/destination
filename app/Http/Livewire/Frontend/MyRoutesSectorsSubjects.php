<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemTag;
use App\Models\ContentLive;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class MyRoutesSectorsSubjects extends Component
{

    use WithPagination;

    public $articles = [];
    public $sortedRouteTags = [];
    public $page = 1;
    public $orderBy = "prefered";
    public $tagType = "route"; //default value
    public $sortedTags = [];

    public function mount($tagType)
    {

        $this->tagType = $tagType;

        if ($this->tagType == "route")
        {

            //gets user assessment routes
            $selfAssessmentTags = app('selfAssessmentSingleton')->getAllocatedRouteTags();

        } elseif ($this->tagType == "sector") {

            //gets user assessment sectors
            $selfAssessmentTags = app('selfAssessmentSingleton')->getAllocatedSectorTags();

        } elseif ($this->tagType == "subject")  {

            //gets user assessment sectors
            $selfAssessmentTags = app('selfAssessmentSingleton')->getAllocatedSubjectTags();

        }


        //if "route" or "sector", we can sorrt by score directly
        if ( ($this->tagType == "route") || ($this->tagType == "sector") )
        {

            //gets the user sorted routes by score
            $this->sortedTags = $selfAssessmentTags->sortBy(function (SystemTag $tag, $key) {
                if (Auth::guard('web')->user()->type == "user")
                {
                    return $tag->pivot->score;
                } else {
                    return 0;
                }

            })->pluck('name', 'id')->toArray();

        //if "subject", we sort by score and then remove the subjects that have a score of 0
        } else {

            //gets the user sorted routes by score
            $this->sortedTags = $selfAssessmentTags->sortBy(function (SystemTag $tag, $key) {
                if (Auth::guard('web')->user()->type == "user")
                {
                    return $tag->pivot->score;
                } else {
                    return 0;
                }

            });

            $this->sortedTags = $this->sortedTags->filter(function ($value, $key) {
                return $value->pivot->score > 0;
            })->pluck('name', 'id')->toArray();

            $this->sortedTags = array_reverse($this->sortedTags);
        }


    }


    public function updated($propertyName)
    {

        if ($propertyName == "orderBy")
        {

            $this->page = 1;

        }

    }


    public function getArticles()
    {

        if ($this->orderBy == "prefered")
        {

            $articles = collect();

            foreach($this->sortedTags as $tag)
            {

                //is the logged in user is a user
                if (Auth::guard('web')->user()->type == 'user'){

                    //collects articles for a specific route tag
                    $articlesCollection = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->withAnyTags($tag, $this->tagType)
                                        ->withAnyTags( [ app('currentTerm') ] , 'term')
                                        ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as title',
                                                'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                                        ->whereIn('template_id', [1, 2, 4])
                                        ->orderBy('summary_heading')
                                        ->get();

                } elseif (Auth::guard('web')->user()->type == 'admin'){

                    //collects articles for a specific route tag
                    $articlesCollection = ContentLive::withAnyTags($tag, $this->tagType)
                                        ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as title',
                                                'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                                        ->whereIn('template_id', [1, 2, 4])
                                        ->orderBy('summary_heading')
                                        ->get();

                }

                                    //merge to collection
                $articles = $articles->merge($articlesCollection);

            }

            //removes duplicated articles
            $articles = $articles->unique();

        } else {

            //is the logged in user is a user
            if (Auth::guard('web')->user()->type == 'user'){

                //collects all relevant route articles in alphabetical order
                $articles = ContentLive::withAnyTags([ Auth::guard('web')->user()->school_year ], 'year')
                                        ->withAnyTags($this->sortedTags, $this->tagType)
                                        ->withAnyTags( [ app('currentTerm') ] , 'term')
                                        ->select('contents_live.id', 'contents_live.template_id', 'contents_live.title as title',
                                                'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                                        ->whereIn('template_id', [1,2,4])
                                        ->orderBy('summary_heading')
                                        ->get();

            } elseif (Auth::guard('web')->user()->type == 'admin'){

                //collects all relevant route articles in alphabetical order
                $articles = ContentLive::select('contents_live.id', 'contents_live.template_id', 'contents_live.title as title',
                                                'contents_live.slug', 'contents_live.summary_heading', 'contents_live.summary_text')
                                        ->whereIn('template_id', [1,2,4])
                                        ->orderBy('summary_heading')
                                        ->get();

            }

        }

        return $articles;
    }

    public function render()
    {

        $perPage = 12;

        $collection = collect( $this->getArticles() );

        if (!is_null($collection))
        {

            $this->nbArticlesFound = $collection->count();

            //prevent the search engine from displaying no results
            //get the maximum page we can navigate
            $max_page = ceil($this->nbArticlesFound / $perPage);
            //if we are viewing a page out of bound, we reset to page 1
            if ($this->page > $max_page)
            {
                $this->page = 1;
            }

            $items = $collection->forPage($this->page, $perPage);

            $paginator = new LengthAwarePaginator($items, $this->nbArticlesFound, $perPage, $this->page);

        } else {

            $this->nbArticlesFound = 0;
            $paginator = [];

        }


        return view('livewire.frontend.my-routes-sectors-subjects', [
            'myTaggedArticles' => $paginator
            ]);

    }

}
