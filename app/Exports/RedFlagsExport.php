<?php

namespace App\Exports;

use App\Models\User;
use App\Models\ContentLive;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Services\Frontend\ReadItAgainService;

class RedFlagsExport implements FromQuery, ShouldQueue, WithHeadings, WithMapping
{

    use Exportable;

    protected $clientId;
    protected $institutionId;
    protected $redFlagArticles = [];
    protected $redFlagArticlesTitles = [];


    public function __construct(int $clientId, int $institutionId)
    {

        $this->clientId = $clientId;
        $this->institutionId = $institutionId;

        $this->redFlagArticles = ContentLive::withAllTags('red flag', 'flag')->orderBy('title', 'ASC')->select('id', 'title')->get()->toArray();

    }



    /**
     * @return array
     */
    public function headings(): array
    {

        $titles = [];
        foreach($this->redFlagArticles as $article)
        {
            $titles[] = $article['title'];
        }

        return array_merge([
            'First name',
            'Surname',
            'Year',
            ],
            $titles
        );

    }



    /**
    * @var User $user
    */
    public function map($user): array
    {

        //gets the articles read by the user
        $redFlagArticlesRead = $user->ArticlesWithTagReadThisYear($user->school_year, 'red flag', 'flag')->select('id')->get();
        if ($redFlagArticlesRead)
        {
            $redFlagArticleRead = $redFlagArticlesRead->toArray();
        }


        //prefills array with default spaces/blanks
        $redFlagArticlesIntersect = array_fill(0, count($this->redFlagArticles), '');

        if (count($redFlagArticleRead)> 0)
        {

            //loops through the articles read by the user
            foreach($redFlagArticleRead as $article)
            {

                //if found in the system list of articles
                $key = array_search($article['id'], array_column($this->redFlagArticles, 'id'));
                if (is_numeric($key))
                {
                    $redFlagArticlesIntersect[$key] = 'Y';
                }

            }

        }

        return array_merge([
            $user->first_name,
            $user->last_name,
            $user->school_year,
            ],
            $redFlagArticlesIntersect,
        );

    }



    public function query()
    {
        return User::query()->select('id', 'first_name', 'last_name', 'school_year')
                            ->where('institution_id', $this->institutionId);

    }


}
