<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\ContentLive;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Services\Frontend\EmployersService;

class EmployerController extends Controller
{

    protected $employersService;

    /**
      * Create a new controller instance.
      *
      * @return void
      */
      public function __construct(EmployersService $employersService)
      {
          $this->employersService = $employersService;
      }



    /**
     * index
     * display all employers
     *
     * @param  mixed $request
     * @return void
     */
    public function index(Request $request)
    {

        $employers = $this->employersService->getAllEmployers();

        return view('frontend.pages.employers.index', compact('employers') );

    }



    /**
     * show
     * Display a single employer
     *
     * @param  mixed $clientSubdomain
     * @param  mixed $employer
     * @return void
     */
    public function show(String $clientSubdomain, ContentLive $employer)
    {

        SEOMeta::setTitle($employer->title);

        //gets the current employer sectors
        $employerSectors = $employer->tagsWithType('sector')->pluck('name')->toArray();

        //returns an employer with similar sector tags
        $relatedEmployer = $this->employersService->getRelatedEmployer($employer->id, $employerSectors);

        //returns an article with similar sector tags
        $relatedArticle = $this->employersService->getRelatedArticle($employerSectors);

        $employerModel = $employer->employer->first();
        if ($employerModel)
        {
            $employerVacancy = $employer->vacanciesLive->take(1)->first();
        } else {
            $employerVacancy = NULL;
        }

        return view('frontend.pages.employers.show', ['content' => $employer,
                                                        'relatedEmployer' => $relatedEmployer,
                                                        'relatedArticle' => $relatedArticle,
                                                        'vacancy' => (!empty($employerVacancy)) ? $employerVacancy : NULL,
                                                    ]);

    }

}
