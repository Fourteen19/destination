<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\SystemTag;
use App\Models\VacancyLive;
use App\Models\VacancyRole;
use Livewire\WithPagination;
use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class VacanciesSearchEngine extends Component
{

    use WithPagination;

    public $keyword = "";
    public $areaList = [];
    public $area;
    public $categoryList = [];
    public $category;
    public $job_type;
    public $jobRoles = [];
    public $vacancies = [];

    //automatically allocated the values of URL query string to the public variables
    protected $queryString = ['keyword', 'area', 'category'];

    public function mount()
    {
        $this->areaList = VacancyRegion::where('client_id', Session::get('fe_client')['id'])->pluck('name', 'uuid');

        $this->categoryList = SystemTag::withType('sector')
                                        //->where('client_id', NULL)
                                        ->orderBy('name', 'ASC')
                                        ->pluck('name', 'uuid');

        $this->jobRoles = VacancyRole::where('display', 'Y')->get();

        $this->job_type = $this->jobRoles->pluck('uuid')->toArray();

    }


    public function submit()
    {

    }




    public function render()
    {

        $perPage = 6;


        //init query
        $query = VacancyLive::with('employerImage.media')->current()->orderBy('created_at', 'DESC');

        //if any keyword is set
        if ($this->keyword)
        {
            /*
            $query = $query->where('title', 'LIKE', "%".$this->keyword."%")
                           ->orwhere('lead_para', 'LIKE', "%".$this->keyword."%");
*/

            $query = $query->where(function($query) {
                            $query->where('title', 'LIKE', "%".$this->keyword."%")
                                  ->orwhere('lead_para', 'LIKE', "%".$this->keyword."%");
            });


        }

        //if the area is set
        if ($this->area)
        {
            $area = VacancyRegion::where('uuid', $this->area)->pluck('id')->first();
            if ($area)
            {
                $query = $query->where('region_id', $area);
            }
        }

        //if the sector is set
        if ($this->category)
        {
            $category = SystemTag::where('uuid', $this->category)->where('type', 'sector')->pluck('name')->first();
            if ($category)
            {
                $query = $query->withAnyTags([$category], 'sector');
            }
        }

        //if the job type is set
         if ($this->job_type)
        {
            $job_types = VacancyRole::whereIn('uuid', $this->job_type)->pluck('id')->toArray();
            if ($job_types)
            {
                $query = $query->whereIn('role_id', $job_types);
            }
        }

        $collection = $query->get();



        if (!is_null($collection))
        {

            $this->nbVacanciesFound = $collection->count();

            //prevent the search engine from displaying no results
            //get the maximum page we can navigate
            $max_page = ceil($this->nbVacanciesFound / $perPage);
            //if we are viewing a page out of bound, we reset to page 1
            if ($this->page > $max_page)
            {
                $this->page = 1;
            }


            $items = $collection->forPage($this->page, $perPage);

            $paginator = new LengthAwarePaginator($items, $this->nbVacanciesFound, $perPage, $this->page);

        } else {
            $this->nbVacanciesFound = 0;
            $paginator = [];
        }


        return view('livewire.frontend.vacancies-search-engine', ['searchVacanciesResults' => $paginator]);

    }
}
