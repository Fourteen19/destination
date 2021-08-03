<?php

namespace App\Exports;

use App\Models\Admin\Admin;
use App\Models\ContentLive;
use App\Models\Institution;
use App\Models\ArticlesTotalStats;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ArticlesExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $userUuid;
    protected $clientId;
    protected $institutionId;
    protected $type;
    protected $template;

    public function __construct(int $clientId, int $institutionId, String $type, String $template, $userUuid)
    {
        $this->userUuid = $userUuid;
        $this->clientId = $clientId;
        $this->institutionId = $institutionId;
        $this->type = $type;
        $this->template = $template;


        //If All Institutions
        if ($this->institutionId == -1)
        {

            $admin = Admin::where('uuid', $userUuid)->first();

            $level = getAdminLevel($admin);

            if ( ($level == 3) || ($level == 2) )
            {
                //finds the institutions filtering by client
                $institutions = Institution::select('id', 'uuid', 'name')->where('client_id', '=', session()->get('adminClientSelectorSelected'))->orderBy('name')->get();
            } else {
                $institutions = $admin->institutions()->get();
            }
            $this->institutionsList = $institutions->pluck('id')->toArray();

        }

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        return [
            'Title',
            'Template',
            'Type',
            'Total views',
            'Total views - Year 7',
            'Total views - Year 8',
            'Total views - Year 9',
            'Total views - Year 10',
            'Total views - Year 11',
            'Total views - Year 12',
            'Total views - Year 13',
            'Total views - Post',
        ];

    }


    /**
    * @var ContentLive $contentLive
    */
    public function map($contentLive): array
    {

        $template = $contentLive->contentTemplate->name;

        $type = (is_null($contentLive->client_id)) ? 'Global' : 'Client';





        //If All institutions
        if ($this->institutionId == -1)
        {

            $stats = DB::table('articles_total_stats')
                        ->select(DB::raw('SUM(total) AS total'),
                                DB::raw('SUM(year_7) AS year_7'),
                                DB::raw('SUM(year_8) AS year_8'),
                                DB::raw('SUM(year_9) AS year_9'),
                                DB::raw('SUM(year_10) AS year_10'),
                                DB::raw('SUM(year_11) AS year_11'),
                                DB::raw('SUM(year_12) AS year_12'),
                                DB::raw('SUM(year_13) AS year_13'),
                                DB::raw('SUM(year_14) AS year_14'),
                                )
                        ->where('content_id', $contentLive->id)
                        ->where('year_id', app('currentYear'))
                        ->whereIn('institution_id', $this->institutionsList)
                        ->where('client_id', $this->clientId)
                        ->first();

        //specific institutions
        } else {

            $stats = DB::table('articles_total_stats')
                        ->select('total', 'year_7', 'year_8', 'year_9', 'year_10', 'year_11', 'year_12', 'year_13', 'year_14')
                        ->where('content_id', $contentLive->id)
                        ->where('year_id', app('currentYear'))
                        ->where('institution_id', $this->institutionId)
                        ->where('client_id', $this->clientId)
                        ->first();
        }



        if (!$stats)
        {
            $statsData = ['0', '0', '0', '0', '0', '0', '0', '0', '0'];
        } else {
            $statsData = [
                ($stats->total == 0) ? '0' : $stats->total,
                ($stats->year_7 == 0) ? '0' : $stats->year_7,
                ($stats->year_8 == 0) ? '0' : $stats->year_8,
                ($stats->year_9 == 0) ? '0' : $stats->year_9,
                ($stats->year_10 == 0) ? '0' : $stats->year_10,
                ($stats->year_11 == 0) ? '0' : $stats->year_11,
                ($stats->year_12 == 0) ? '0' : $stats->year_12,
                ($stats->year_13 == 0) ? '0' : $stats->year_13,
                ($stats->year_14 == 0) ? '0' : $stats->year_14,
            ];
        }

        return array_merge([
            $contentLive->title,
            $template,
            $type,
        ],
            $statsData
        );
    }



    public function query()
    {
        $content = ContentLive::query()->select('id', 'title', 'template_id', 'client_id')
                            ->with('contentTemplate')
                            //->with('articlesTotalStats')
                            ->orderby('title', 'asc');


        if ($this->type == "client")
        {
            $content = $content->where('client_id', session()->get('adminClientSelectorSelected'));
        } elseif ($this->type == "global") {
            $content = $content->where('client_id', NULL);
        }

        if ($this->template == "article")
        {
            $content = $content->where('template_id', 1);
        } elseif ($this->template == "accordion") {
            $content = $content->where('template_id', 2);
        } elseif ($this->template == "employer_profile") {
            $content = $content->where('template_id', 3);
        } elseif ($this->template == "work_experience") {
            $content = $content->where('template_id', 4);
        }



/*
        //for the join of articlesStats... if it can be made to work
        if ($this->institutionId)
        {
            $content = $content->whereHas('articlesTotalStats', function($query) {
                $query->where('institution_id', $this->institutionId);
            });
        }
*/
        return $content;

    }
}
