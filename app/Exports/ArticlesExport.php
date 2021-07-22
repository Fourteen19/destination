<?php

namespace App\Exports;


use App\Models\ContentLive;
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
            'Total views - Year 14',
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

        return [
            $contentLive->title,
            $template,
            $type,
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
            "0",
        ];
    }



    public function query()
    {
        $content = ContentLive::query()->select('title', 'template_id', 'client_id')
                            ->with('contentTemplate')
                            ->with('articlesTotalStats');


        if ($this->type == "client")
        {
            $content = $content->where('client_id', session()->get('adminClientSelectorSelected'));
        } elseif ($this->type == "global") {
            $content = $content->where('client_id', NULL);
        }

        if ($this->template == "article")
        {
            $content = $content->where('template_id', 1);
        } elseif ($this->type == "accordion") {
            $content = $content->where('template_id', 2);
        } elseif ($this->type == "employer_profile") {
            $content = $content->where('template_id', 3);
        } elseif ($this->type == "work_experience") {
            $content = $content->where('template_id', 4);
        }

        if ($this->institutionId)
        {
            $content = $content->whereHas('articlesTotalStats', function($query) {
                $query->where('institution_id', $this->institutionId);
            });
        }

        return $content;

//->where('institution_id', $this->institutionId);

    }
}
