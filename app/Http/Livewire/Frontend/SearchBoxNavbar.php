<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemKeywordTag;
use Illuminate\Support\Facades\Session;



class SearchBoxNavbar extends Component
{

    public $search = "";
    public $searchResults = [];

    public function render()
    {
/*
        if (!empty($this->search))
        {

            if (strlen($this->search) > 2){

                $this->searchString = strtolower($this->search);

                $this->searchResults = SystemKeywordTag::where("slug", "LIKE", "%".$this->searchString."%")
                                                        ->where("client_id", Session::get('client')->id)
                                                        ->select('uuid', 'name')
                                                        ->get()
                                                        ->toArray();

            }

        }

*/



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
                $this->searchResults = $query->get()->toArray();
//dd($this->searchKeywordsResults);
            }

        }












        return view('livewire.frontend.search-box-navbar');

    }
}
