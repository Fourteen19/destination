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

    public $eventSuggestionsIsVisible = False;
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
                        $this->eventSuggestionsIsVisible = False;
                    }

                    $this->filterEventsWithString();

                    $this->navigatingFromNavbar = 0;

                } else {
                    $this->eventSuggestionsIsVisible = True;
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

        $this->eventSuggestionsIsVisible = False;

    }




    public function filterEventsWithString()
    {

        $this->filterType = "filterEventsWithString";
        $this->searchedTerm = $this->search;

        $this->eventSuggestionsIsVisible = False;

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
