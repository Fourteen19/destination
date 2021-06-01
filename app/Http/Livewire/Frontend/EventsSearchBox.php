<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Session;



class EventsSearchBox extends Component
{

    public $event_search = "";
    public $searchResults = [];

    public $searchFormKey;

    //setup of the component
    public function mount()
    {

        $this->searchFormKey = "events-search-form-" . time();

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

                $query = SystemKeywordTag::where("client_id", Session::get('fe_client')->id)
                                          ->select('uuid', 'name')
                                          ->where(function($query) use ($queryParam) {
                                            foreach ($this->searchString as $string)
                                            {
                                                if (!empty($string))
                                                    $query->orwhere("slug", "LIKE", "%".$string."%");
                                            }
                                        });
//dd($query->toSql());
                $this->searchResults = $query->get()->toArray();
//dd($this->searchKeywordsResults);
            }

        }

        return view('livewire.frontend.events-search-box');

    }
}
