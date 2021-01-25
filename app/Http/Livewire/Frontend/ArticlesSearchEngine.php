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

    public $keywordsList = ""; //text displayed on the left
    public $nbArticlesFound = 0;

    public $searchCompleted = 0;
    public $results = []; //articles found



    public function mount(Request $request)
    {

        $keywordSearchString = request('searchTerm');
        if (!empty($keywordSearchString)){
            $this->search = $keywordSearchString;
        }

        $this->filterSearchString();

        $this->filterArticles($this->search);

    }




    public function filterSearchString()
    {

        $this->searchCompleted = 1;

        if (!empty($this->search))
        {

            if (strlen($this->search) > 2){


                $this->searchString = remove_common_words( strtolower($this->search) );

                $this->searchString = explode(" ", $this->searchString);

                $queryParam = $this->searchString;

                $query = SystemKeywordTag::where("client_id", Session::get('client')->id)
                                          ->select('uuid', 'name')
                                          ->where(function($query) use ($queryParam) {
                                            foreach ($this->searchString as $string)
                                            {
                                                if (!empty($string))
                                                    $query->orwhere("slug", "LIKE", "%".$string."%");
                                            }
                                        });
//dd($query->toSql());
                $this->searchKeywordsResults = $query->get()->toArray();
//dd($this->searchKeywordsResults);
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

        //if the submit button was clicked
        if (empty($searchArticlesString))
        {

            $this->results = [];

            $this->filterSearchString();
            //dd($this->searchResults);

        //else if an option was selected from the keywords
        } else {

            //dd($searchArticlesString);
/*
            $this->results = ContentLive::where("client_id", '=', Session::get('client')->id)
                                          ->orwhere("client_id", '=', 'NULL')
                                          ->select('slug', 'summary_heading', 'summary_text')
                                          ->paginate(10);

                                         //dd($this->results);
            $this->nbArticlesFound = count($this->results);
        */     }




    }



    public function render()
    {
/*
        return view('livewire.frontend.articles-search-engine', [
            'articles' => ContentLive::where("client_id", '=', Session::get('client')->id)
            ->orwhere("client_id", '=', 'NULL')
            ->select('slug', 'summary_heading', 'summary_text')
            ->paginate(10),
        ]);
*/

        return view('livewire.frontend.articles-search-engine', [
            'articles' => ContentLive::where("client_id", '=', Session::get('client')->id)
                                    ->orwhere("client_id", '=', 'NULL')
                                    ->select('slug', 'summary_heading', 'summary_text')
                                    ->paginate(10),
        ]);

    }
}
