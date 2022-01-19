<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;



class EventsSearchBox extends Component
{

    public $event_search = "";
    public $searchResults = [];

    public $searchFormKey;
    public $eventSuggestionsVisible = False;
    public $event_filter;

    //setup of the component
    public function mount()
    {

        $this->searchFormKey = "events-search-form-" . time();

        //Tick the event filter based on the URL
        if (in_array('events-best-match', Request::segments() ) )
        {
            $this->event_filter = "best_match";
        } else {
            $this->event_filter = "all_events";
        }

    }

    /**
     * seachKeyword
     *
     * @return void
     */
    public function submit()
    {

        //redirects to the seach screen
        redirect()->route('frontend.events-search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => $this->event_search] );
    }




    public function render()
    {

        if (!empty($this->event_search))
        {

            if (strlen($this->event_search) > 2){

                $this->searchString = remove_common_words( strtolower($this->event_search) );

                $this->searchString = explode(" ", $this->searchString);

                $queryParam = $this->searchString;

                $query = SystemKeywordTag::where("client_id", Session::get('fe_client')['id'])
                                          ->select('uuid', 'name')
                                          ->where(function($query) use ($queryParam) {
                                            foreach ($this->searchString as $string)
                                            {
                                                if (!empty($string))
                                                    $query->orwhere("slug", "LIKE", "%".$string."%");
                                                    $query->orwhere("slug", "=", $string);
                                            }
                                        });

                $this->searchResults = $query->get()->toArray();

                if (count($this->searchResults) > 0)
                {
                    $this->eventSuggestionsVisible = True;
                } else {
                    $this->eventSuggestionsVisible = False;
                }
            }

        }

        return view('livewire.frontend.events-search-box');

    }
}
