<?php

namespace App\Http\Controllers\FrontEnd;


use Carbon\Carbon;
use App\Models\Employer;
use App\Models\EmployerLive;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Session;

class CompanyController extends Controller
{


    /**
      * Create a new controller instance.
      *
      * @return void
   */
    public function __construct() {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        SEOMeta::setTitle("Companies");

        $companies = DB::select( DB::raw("SELECT `employers`.`name`, `employers`.`slug`, count(`vacancies_live`.`id`) as nb_vacancies
                                        FROM `employers` AS `employers`
                                        LEFT OUTER JOIN `vacancies_live` AS `vacancies_live`
                                        ON `vacancies_live`.`employer_id` = `employers`.`id`
                                        WHERE
                                        `vacancies_live`.`deleted_at` IS NULL AND
                                        `employers`.`deleted_at` IS NULL AND
                                        (`vacancies_live`.`display_until` IS NULL OR `vacancies_live`.`display_until` >= '".Carbon::today()->toDateString()."') AND
                                        (
                                            (`vacancies_live`.`all_clients` = 'Y')
                                            OR
                                            (exists (select * from `clients` inner join
                                                                `clients_vacancies_live` on `clients`.`id` = `clients_vacancies_live`.`client_id`
                                                                where
                                                                `vacancies_live`.`id` = `clients_vacancies_live`.`vacancy_live_id` and
                                                                `client_id` = ".Session::get('fe_client')['id']." and
                                                                `clients`.`deleted_at` is null)
                                            )
                                        )
                                        GROUP BY `employers`.`name`, `employers`.`slug`
                                        HAVING count(`vacancies_live`.`id`) > 0
                                        ORDER BY `employers`.`name` ASC"));

        $companies_list = [];
        foreach($companies as $company)
        {
            $letter = substr($company->name, 0, 1);
            $companies_list[strtoupper($letter)][] = $company;
        }

        return view('frontend.pages.companies.index', ["companies_list" => $companies_list]);

    }




    public function show($clientSubdomain, EmployerLive $company)
    {

        SEOMeta::setTitle($company->name);

        $relatedArticle = $company->article;

        return view('frontend.pages.companies.show', ['company' => $company,
                                                      'relatedArticle' => $relatedArticle
                                                    ]);

    }
}
