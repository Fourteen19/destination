<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Frontend\ActivitiesService;
use Illuminate\Pagination\LengthAwarePaginator;

class AllSuggestedActivitiesWithPagination extends Component
{
    use WithPagination;

    public $page = 1;

    public function render()
    {

        $perPage = 2;

        $activitiesService = new ActivitiesService();

        $collection = $activitiesService->getAllActivitiesNotCompletedByUser();

        if (!isset($this->page))
        {
            $this->page = 1;
        }

        if (!is_null($collection))
        {

            $items = $collection->forPage($this->page, $perPage);

            $this->nbArticlesFound = $collection->count();

            $paginator = new LengthAwarePaginator($items, $this->nbArticlesFound, $perPage, $this->page);

        } else {
            $this->nbArticlesFound = 0;
            $paginator = [];
        }


        return view('livewire.frontend.all-suggested-activities-with-pagination', [
            'activities' => $paginator
            ]);


    }
}
