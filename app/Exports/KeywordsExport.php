<?php

namespace App\Exports;

use App\Models\ContentLive;
use App\Models\SystemKeywordTag;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KeywordsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

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

        return [
            $tag->name,
            $nbArticles,
            2,
            7,
            8,
            9,
            10,
            11,
            12,
            13,
            14,
        ];
    }


    public function query()
    {
        return SystemKeywordTag::query()->where('type', 'keyword')->where('live', 'Y')->where('client_id', session()->get('adminClientSelectorSelected'))->orderBy('name', 'asc');
    }
}
