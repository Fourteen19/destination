<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemTag;
use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Session;

class VacanciesSearchEngine extends Component
{

    public $keyword = "";
    public $areaList = [];
    public $area;
    public $categoryList = [];
    public $category;

    public function mount()
    {
        $this->areaList = VacancyRegion::where('client_id', Session::get('fe_client')->id)->pluck('name', 'uuid');

        $this->categoryList = SystemTag::withType('sector')
                                        ->where('client_id', NULL)
                                        ->orderBy('name', 'ASC')
                                        ->pluck('name', 'uuid');

    }



    public function submit()
    {

        $this->emit('vacancySearch', $this->keyword, $this->area, $this->category);


    }


    public function render()
    {
        return view('livewire.frontend.vacancies-search-engine');
    }
}
