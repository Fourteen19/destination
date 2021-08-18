<?php

namespace App\Http\Livewire\Frontend;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\KeywordsTagsTotalStats;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\Frontend\ArticlesSearchService;



class ArticlesSearchEngine extends Component
{

    use WithPagination;

    public $search = "";
    public $searchedTerm = "";

    public $searchKeywordsResults = [];
    public $searchKeywordsResultsSelected = "";

    public $keywordsList = ""; //text displayed on the left
    public $nbArticlesFound = 0;

    public $searchCompleted = 0;
    protected $results; //articles found

    public $isVisible = False;
    public $navigatingFromNavbar = 0;

    public $filterType;

    public function mount()
    {

        if (!empty(request('searchTerm'))){
            $this->searchedTerm = $this->search = trim(request('searchTerm'));
            $this->navigatingFromNavbar = 1;

            //filter the
            $this->filterArticlesByKeyword($this->search);


            //$this->updatedSearch($this->search);

            $this->filterSearchString();

            //makes sure the suggestion box is not visible when the page loads up
            $this->isVisible = False;
        }

    }



    /**
     * attachKeywordToUser
     * Attach keyword to the list of keywords used by a user in searches
     *
     * @param  mixed $keyword
     * @return void
     */
    public function attachKeywordToUser($keyword)
    {

        //fetches the tag by name
        $tag = SystemKeywordTag::matching($keyword)->where('type', 'keyword')->select('id', 'uuid', 'name')->first();

        if ($tag)
        {

            $tag = $tag->toArray();

            //if the tag has not been attached to the user yet
            if (!Auth::guard('web')->user()->searchedKeywords()->where('system_keyword_tag_id', '=', $tag['id'])->exists() )
            {

                //if the tag exists
                if ($tag)
                {
                    $current_timestamp = Carbon::now()->toDateTimeString();

                    //attaches the keyword tag against the current user
                    Auth::guard('web')->user()->searchedKeywords()->attach($tag['id'], ['created_at'=>$current_timestamp, 'updated_at'=>$current_timestamp]);
                }

            }

        }

    }


    public function filterSearchString()
    {

        if (!empty($this->search))
        {
            //$this->search = trim($this->search);
            $this->searchKeywordsResults = [];

            if (strlen($this->search) > 2){

                $articlesSearchService = new ArticlesSearchService();
                $this->searchKeywordsResults = $articlesSearchService->getKeywordsFromSearchString($this->search, "suggestions");

                if (count($this->searchKeywordsResults) > 0)
                {
                    $this->isVisible = True;
                } else {
                    $this->isVisible = False;
                }


            }

        }

    }



    //Runs after any update to the Livewire component's data
    //Runs the filter everytime the user stops typing
    public function updatedSearch($value)
    {
        $this->search = $value;
        //dd($value);
       $this->filterSearchString();
    }




    /**
     * updateKeywordStats
     * updates the keywords stats and increase the tallies
     *
     * @param  mixed $tagName
     * @return void
     */
    public function updateKeywordStats($tagName)
    {

        $tag = SystemKeywordTag::matching($tagName)->withType('keyword')->get();

        if (count($tag) == 1)
        {

            $year = Auth::guard('web')->user()->school_year;

            //updates the article keywords
            KeywordsTagsTotalStats::updateorCreate(
                ['client_id' => Auth::guard('web')->user()->client_id,
                'institution_id' => Auth::guard('web')->user()->institution_id,
                'year_id' => app('currentYear'),
                'tag_id' => $tag->first()->id,
                ],
                ['year_'.$year =>  DB::raw('year_'.$year.' + 1'),
                'total' =>  DB::raw('total + 1')
                ]
            );

        }

    }


    public function filterArticlesWithKeyword($searchArticlesString = NULL)
    {

        $this->updateKeywordStats($searchArticlesString);

        $this->filterArticlesByKeyword($searchArticlesString);

    }




    public function filterArticlesByKeyword($searchArticlesString = NULL)
    {

        $this->search = $searchArticlesString;
        $this->searchedTerm = $searchArticlesString;

        $this->filterType = "filterArticlesWithKeyword";

        //saves keyword to DB
        $this->attachKeywordToUser($searchArticlesString);

        $this->isVisible = False;

    }



    public function filterArticlesWithString()
    {

        $this->filterType = "filterArticlesWithString";
        $this->searchedTerm = $this->search;

        $this->isVisible = False;

    }




    public function render()
    {

        $perPage = 12;

        $articlesSearchService = new ArticlesSearchService();

        if ($this->filterType == "filterArticlesWithKeyword")
        {
            if ($this->searchedTerm != "")
            {
                $searchWithThis = $this->searchedTerm;
            } else {
                $searchWithThis = $this->search;
            }

            $this->results = $articlesSearchService->getMyArticlesWithKeyword($searchWithThis);

        } elseif ($this->filterType == "filterArticlesWithString")
        {

            if ($this->searchedTerm != "")
            {
                $searchWithThis = $this->searchedTerm;
            } else {
                $searchWithThis = $this->search;
            }

            $this->results = $articlesSearchService->getMyArticlesWithString($searchWithThis);

        }




        $collection = $this->results;

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



        return view('livewire.frontend.articles-search-engine', [
            'articles' => $paginator
            ]);


    }
}
