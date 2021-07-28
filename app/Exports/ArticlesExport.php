<?php

namespace App\Exports;

use App\Models\ContentLive;
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

    protected $clientId;
    protected $institutionId;
    protected $type;
    protected $template;

    public function __construct(int $clientId, int $institutionId, String $type, String $template)
    {
        $this->clientId = $clientId;
        $this->institutionId = $institutionId;
        $this->type = $type;
        $this->template = $template;

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


        $stats = DB::table('articles_total_stats')
                        ->select('total', 'year_7', 'year_8', 'year_9', 'year_10', 'year_11', 'year_12', 'year_13', 'year_14')
                        ->where('content_id', $contentLive->id)
                        ->where('year_id', app('currentYear'))
                        ->where('institution_id', $this->institutionId)
                        ->where('client_id', $this->clientId)
                        ->first();


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
