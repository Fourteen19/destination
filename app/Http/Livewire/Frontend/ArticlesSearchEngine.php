<?php

namespace App\Http\Livewire\Frontend;

use App\Models\User;
use Livewire\Component;
use App\Models\ContentLive;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
            $this->searchedTerm = $this->search = request('searchTerm');
            $this->navigatingFromNavbar = 1;

            $this->filterSearchString();
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
//dd($keyword);
        //fetches the tag by name
        $tag = SystemKeywordTag::matching($keyword)->where('type', 'keyword')->select('id', 'uuid', 'name')->first()->toArray();

        //if the tag has not been attached to the user yet
        if (!Auth::guard('web')->user()->searchedKeywords()->where('system_keyword_tag_id', '=', $tag['id'])->exists() )
        {

            //if the tag exists
            if ($tag)
            {
                //attaches the keyword tag against the current user
                Auth::guard('web')->user()->searchedKeywords()->attach($tag['id']);
            }

        }

    }


    public function filterSearchString()
    {

        if (!empty($this->search))
        {

            if (strlen($this->search) > 2){


                $articlesSearchService = new ArticlesSearchService();
                $this->searchKeywordsResults = $articlesSearchService->getKeywordsFromSearchString($this->search);


                if ($this->navigatingFromNavbar == 1)
                {
                    if (count($this->searchKeywordsResults) > 0)
                    {
                        $this->isVisible = False;
                    }

                    $this->filterArticlesWithString();

                    $this->navigatingFromNavbar = 0;

                } else {
                    $this->isVisible = True;
                }

            }

        }

    }


    public function updatingSearch()
    {

        //$this->resetPage();
    }

    public function updatedSearch($value)
    {

       $this->filterSearchString();
    }




    public function filterArticlesWithKeyword($searchArticlesString = NULL)
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

        $articlesSearchService  = new ArticlesSearchService();

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

            $items = $collection->forPage($this->page, $perPage);

            $paginator = new LengthAwarePaginator($items, $collection->count(), $perPage, $this->page);

        } else {
            $paginator = [];
        }



        return view('livewire.frontend.articles-search-engine', [
            'articles' => $paginator
            ]);


    }
}
