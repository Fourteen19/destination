<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Session;



class SearchBoxNavbar extends Component
{

    public $search = "";
    public $searchResults = [];

    public $searchFormKey;
    public $articlesSuggestionsVisible = False;

    //setup of the component
    public function mount()
    {

        $this->searchFormKey = "search-form-" . time();

    }

    /**
     * seachKeyword
     *
     * @return void
     */
    public function submit()
    {

        //redirects to the seach screen
        redirect()->route('frontend.search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => parse_encode_url($this->search)] );
    }


    public function render()
    {

        if (!empty($this->search))
        {

            if (strlen($this->search) > 2){

                $this->searchString = remove_common_words( strtolower($this->search) );

                $this->searchString = explode(" ", $this->searchString);

                $queryParam = $this->searchString;

                $query = SystemKeywordTag::where("client_id", Session::get('fe_client')->id)
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
                    $this->articlesSuggestionsVisible = True;
                } else {
                    $this->articlesSuggestionsVisible = False;
                }
            }

        }

        return view('livewire.frontend.search-box-navbar');

    }
}
