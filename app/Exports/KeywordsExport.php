<?php

namespace App\Exports;

use App\Models\ContentLive;
use App\Models\SystemKeywordTag;
use App\Models\KeywordsTagsTotalStats;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeywordsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;

    public function __construct(int $clientId, int $institutionId)
    {
        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

    }


    /**
     * @return array
     */
    public function headings(): array
    {

        return [
            'Keyword',
            'Number of matching articles',
            'Total searches',
            'Total searches - Year 7',
            'Total searches - Year 8',
            'Total searches - Year 9',
            'Total searches - Year 10',
            'Total searches - Year 11',
            'Total searches - Year 12',
            'Total searches - Year 13',
            'Total searches - Post',
        ];

    }

    /**
    * @var SystemKeywordTag $tag
    */
    public function map($tag): array
    {

        //counts the number of articles using the tag
        $nbArticles = ContentLive::withAnyTags([$tag->name], 'keyword')->count();

        $stats = $tag->articlesTotalStats;

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
            $tag->name,
            $nbArticles,
        ],
            $statsData
        );

    }



    public function query()
    {

        $institutionId = $this->institutionId;

        return SystemKeywordTag::query()->where('type', 'keyword')
                                        ->where('client_id', $this->clientId)
                                        ->where('live', 'Y')
                                        ->with('keywordsTagsTotalStats', function ($query) use ($institutionId) {
                                            $query->select('tag_id', 'total', 'year_7', 'year_8', 'year_9', 'year_10', 'year_11', 'year_12', 'year_13', 'year_14')
                                                ->where('year_id', app('currentYear') )
                                                ->where('institution_id', $institutionId);

                                        })
                                        ->orderBy('name', 'asc');
    }

}
