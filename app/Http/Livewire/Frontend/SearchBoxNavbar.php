<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\KeywordsTagsTotalStats;
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
     * clickKeyword
     * triggered when a keyword is clicked on
     *
     * @return void
     */
    public function clickKeyword($tagName)
    {

        $keywordTag = SystemKeywordTag::query()
            ->where('name->en', $tagName)
            ->where('type', 'keyword')
            ->where('live', 'Y')
            ->first();

        if ($keywordTag)
        {

            if (Auth::guard('web')->user()->type == "user")
            {

                $year = Auth::guard('web')->user()->school_year;

                KeywordsTagsTotalStats::updateorCreate(
                    ['client_id' => Auth::guard('web')->user()->client_id,
                    'institution_id' => Auth::guard('web')->user()->institution_id,
                    'year_id' => app('currentYear'),
                    'tag_id' => $keywordTag->id,
                    ],
                    ['year_'.$year =>  DB::raw('year_'.$year.' + 1'),
                    'total' =>  DB::raw('total + 1')
                    ]
                );
            }



            //redirects to the seach screen
            redirect()->route('frontend.search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => parse_encode_url($tagName)] );

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
        redirect()->route('frontend.search', ['clientSubdomain' => session('fe_client.subdomain'), 'searchTerm' => parse_encode_url($this->search)] );
    }


    public function render()
    {

        if (!empty($this->search))
        {

            $this->searchResults = [];

            if (strlen($this->search) > 2){

                $this->searchString = remove_common_words( strtolower($this->search) );

                $this->searchString = explode(" ", $this->searchString);

                $queryParam = $this->searchString;

                $query = SystemKeywordTag::where("type", 'keyword')
                                          ->where("live", 'Y')
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

                //if (count($this->searchResults) > 0)
                if (!empty($this->searchResults))
                {
                    $this->articlesSuggestionsVisible = True;
                } else {
                    $this->articlesSuggestionsVisible = False;
                }
            }

        } else {


        }

        return view('livewire.frontend.search-box-navbar');

    }
}
