<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\ContentLive;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Session;



class ArticlesSearchEngine extends Component
{

    use WithPagination;

    public $search = "";
    public $searchKeywordsResults = [];
    public $searchKeywordsResultsSelected = "";

    public $keywordsList = ""; //text displayed on the left
    public $nbArticlesFound = 0;

    public $searchCompleted = 0;
    protected $results = []; //articles found

    public $isVisible = False;
    public $navigatingFromNavbar = 0;

    public function mount()
    {

        //$keywordSearchString = request('searchTerm');
        if (!empty(request('searchTerm'))){
            $this->search = request('searchTerm');
            $this->navigatingFromNavbar = 1;
        }

        $this->filterSearchString();

        if (count($this->searchKeywordsResults) == 1)
        {
            //$this->filterArticles($this->search);
            $this->filterArticles($this->searchKeywordsResults[0]['name']['en']);
        }

    }




    public function filterSearchString()
    {

        if (!empty($this->search))
        {

            if (strlen($this->search) > 2){


                $this->searchString = remove_common_words( strtolower($this->search) );

                $this->searchString = explode(" ", $this->searchString);

                $queryParam = $this->searchString;

                $query = SystemKeywordTag::where("client_id", Session::get('client')->id)
                                          ->select('name')
                                          ->where("live", '=', 'Y')
                                          ->where(function($query) use ($queryParam) {
                                            foreach ($this->searchString as $string)
                                            {
                                                if (!empty($string))
                                                    $query->orwhere("slug", "LIKE", "%".$string."%");
                                            }
                                        });

                $this->searchKeywordsResults = $query->get()->toArray();

                if ($this->navigatingFromNavbar == 1)
                {
                    if (count($this->searchKeywordsResults) > 0)
                    {
                        $this->isVisible = True;
                    } else {
                        $this->isVisible = False;
                    }

                } else {
                    $this->isVisible = True;
                }

            }

        }

    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch($value)
    {

       $this->filterSearchString();
    }


    public function filterArticles($searchArticlesString = NULL)
    {
//dd(1);
        //if the submit button was clicked
        if (empty($searchArticlesString))
        {

      //     $this->results = [];

            $this->filterSearchString();

        //else if an option was selected from the keywords
        } else {

            $this->search = $searchArticlesString;

            $this->searchKeywordsResults = [ ['name' => [ 'en'=> $searchArticlesString ] ]];

            $this->searchKeywordsResultsSelected = $searchArticlesString;
/*
            $this->results = ContentLive::where("client_id", '=', Session::get('client')->id)
                                          ->orwhere("client_id", '=', 'NULL')
                                          ->select('slug', 'summary_heading', 'summary_text')
                                          ->paginate(10);

            $this->nbArticlesFound = $this->results->total();

            $this->searchCompleted = 1;
*/        }

    }



    public function render()
    {
        //dd(2);
        if (!empty($this->searchKeywordsResultsSelected))
        {

            //need to cache this query OR use a service
            $this->results = ContentLive::where("client_id", '=', Session::get('client')->id)
                                          ->orwhere("client_id", '=', 'NULL')
                                          ->select('slug', 'summary_heading', 'summary_text')
                                          ->paginate(12);

            $this->nbArticlesFound = $this->results->total();

            $this->searchCompleted = 1;
        } else {

            $this->results = [];
        }


        return view('livewire.frontend.articles-search-engine', [
            'articles' => $this->results
            ]);


    }
}
