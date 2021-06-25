<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;

class VacanciesSearchEngineResults extends Component
{

    protected $listeners = ['vacancySearch' => 'vacancySearch'];

    public function mount()
    {
        

    }


    public function vacancySearch($keyword, $area, $category)
    {

        dd($category);

    }

    public function render()
    {
        return view('livewire.frontend.vacancies-search-engine-results');
    }
}
