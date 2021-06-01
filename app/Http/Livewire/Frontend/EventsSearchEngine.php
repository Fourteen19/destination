<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Auth;
use App\Services\Frontend\EventsSearchService;
use Illuminate\Pagination\LengthAwarePaginator;


class EventsSearchEngine extends Component
{

    use WithPagination;

    public $search = "";
    public $searchedTerm = "";

    public $searchKeywordsResults = [];
    public $searchKeywordsResultsSelected = "";

    public $keywordsList = ""; //text displayed on the left
    public $nbEventsFound = 0;

    public $searchCompleted = 0;
    protected $results; //events found

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

                $eventsSearchService = new EventsSearchService();
                $this->searchKeywordsResults = $eventsSearchService->getKeywordsFromSearchString($this->search);


                if ($this->navigatingFromNavbar == 1)
                {
                    if (count($this->searchKeywordsResults) > 0)
                    {
                        $this->isVisible = False;
                    }

                    $this->filterEventsWithString();

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




    public function filterEventsWithKeyword($searchEventsString = NULL)
    {

        $this->search = $searchEventsString;
        $this->searchedTerm = $searchEventsString;

        $this->filterType = "filterEventsWithKeyword";

        //saves keyword to DB
        $this->attachKeywordToUser($searchEventsString);

        $this->isVisible = False;

    }




    public function filterEventsWithString()
    {

        $this->filterType = "filterEventsWithString";
        $this->searchedTerm = $this->search;

        $this->isVisible = False;

    }




    public function render()
    {

        $perPage = 12;

        $eventsSearchService  = new EventsSearchService();

        if ($this->filterType == "filterEventsWithKeyword")
        {
            if ($this->searchedTerm != "")
            {
                $searchWithThis = $this->searchedTerm;
            } else {
                $searchWithThis = $this->search;
            }

            $this->results = $eventsSearchService->getMyEventsWithKeyword($searchWithThis);

        } elseif ($this->filterType == "filterEventsWithString")
        {

            if ($this->searchedTerm != "")
            {
                $searchWithThis = $this->searchedTerm;
            } else {
                $searchWithThis = $this->search;
            }

            $this->results = $eventsSearchService->getMyEventsWithString($searchWithThis);

        }




        $collection = $this->results;

        if (!is_null($collection))
        {

            $items = $collection->forPage($this->page, $perPage);

            $this->nbEventsFound = $collection->count();

            $paginator = new LengthAwarePaginator($items, $this->nbEventsFound, $perPage, $this->page);

        } else {
            $this->nbEventsFound = 0;
            $paginator = [];
        }



        return view('livewire.frontend.events-search-engine', [
            'events' => $paginator
            ]);


    }
}
