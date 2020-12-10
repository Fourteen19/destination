<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Video;
use App\Models\Content;
use App\Models\ContentLive;
use App\Models\RelatedLink;
use Illuminate\Support\Str;
use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use App\Models\RelatedDownload;
use App\Services\ContentService;
use App\Models\ContentArticleLive;
use Illuminate\Support\Facades\Auth;



Class ContentArticleService extends ContentService
{

    public function storeLivewire($data)
    {

        //create the `article` record
        $article = ContentArticle::create([
            'title' => $data->title,
            'lead' => $data->lead,
            'subheading' => $data->subheading,
            'body' => $data->body,
            'alt_block_heading' => $data->alt_block_heading,
            'alt_block_text' => $data->alt_block_text,
            'lower_body' => $data->lower_body,
            'summary_heading' => $data->summary_heading,
            'summary_text' => $data->summary_text,
        ]);

        //fetch the template
        $template = ContentTemplate::where('Name', 'Article')->first();

        //creates the `content` record
        $newContent = $article->content()->create([
                        'template_id' => $template->id,
                        'title' => $data->title,
                        'slug' => $data->slug,
                        'client_id' => Auth::guard('admin')->user()->client_id
                    ]);


        $this->attachTags($data);

        //return the new content
        return $newContent;

    }



    public function editLivewire($data)
    {

        //updates the resource
        $data->content->update([
            'title' => $data->title,
            'timestamps' => false,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        //updates the resource
        $data->content->contentable->update([
            'title' => $data->title,
            'lead' => $data->lead,
            'subheading' => $data->subheading,
            'body' => $data->body,
            'alt_block_heading' => $data->alt_block_heading,
            'alt_block_text' => $data->alt_block_text,
            'lower_body' => $data->lower_body,
            'summary_heading' => $data->summary_heading,
            'summary_text' => $data->summary_text,
        ]);


        $this->syncTags($data);

        return $data->content;

    }



    public function storeAndMakeLive($data)
    {

        $content = $this->store($data);

        $this->makeLive($content);

    }




    public function store($data)
    {

        if ($data->action == 'add')
        {

            $content = $this->storeLivewire($data);


        } elseif ($data->action == 'edit'){

            $content = $this->editLivewire($data);

        }

        /** Attach videos **/
        $this->saveVideos($data);

        /** Attach links **/
        $this->saveRelatedLinks($data);

        /** Attach downloads **/
        $this->saveRelatedDownloads($data);


        return $content;

    }



    public function resetAllContentTags($data)
    {

        $data->content->syncTagsWithType([], 'year');
        $data->content->syncTagsWithType([], 'route');
        $data->content->syncTagsWithType([], 'lscs');
        $data->content->syncTagsWithType([], 'sector');
        $data->content->syncTagsWithType([], 'subject');
        $data->content->syncTagsWithType([], 'flag');

    }




    public function attachTags($data)
    {

        $data->content->attachTags( !empty($data->contentYearGroupsTags) ? $data->contentYearGroupsTags : [] , 'year' );
        $data->content->attachTags( !empty($data->contentLscsTags) ? $data->contentLscsTags : [] , 'lscs' );
        $data->content->attachTags( !empty($data->contentRoutesTags) ? $data->contentRoutesTags : [] , 'route' );
        $data->content->attachTags( !empty($data->contentSectorsTags) ? $data->contentSectorsTags : [] , 'sector' );
        $data->content->attachTags( !empty($data->contentSubjectTags) ? $data->contentSubjectTags : [] , 'subject' );
        $data->content->attachTags( !empty($data->contentFlagTags) ? $data->contentFlagTags : [] , 'flag' );

    }


    public function syncTags($data)
    {

        $this->resetAllContentTags($data);

        $this->attachTags($data);

/*
        $data->content->syncTagsWithType($data->contentYearGroupsTags, 'year');
        $data->content->syncTagsWithType($data->contentLscsTags, 'lscs');
        $data->content->syncTagsWithType($data->contentRoutesTags, 'route');
        $data->content->syncTagsWithType($data->contentSectorsTags, 'sector');
        $data->content->syncTagsWithType($data->contentSubjectTags, 'subject');
*/
    }


    public function saveVideos($data)
    {
        //delete all existing videos
        $data->content->videos()->delete();

        //create the videos to attach to content
        foreach($data->videos as $key => $value){

            $model = new Video();
            $model->url = $value['url'];

            $data->content->videos()->save($model);
        }

    }



    public function saveRelatedLinks($data)
    {

        //delete all existing links
        $data->content->related_links()->delete();

        //create the links to attach to content
        foreach($data->relatedLinks as $key => $value){

            $model = new RelatedLink();
            $model->title = $value['title'];
            $model->url = $value['url'];

            $data->content->related_links()->save($model);
        }

    }



    public function saveRelatedDownloads($data)
    {

        //delete all existing downloads
        $data->content->related_downloads()->delete();

        //create the downloads to attach to content
        foreach($data->relatedDownloads as $key => $value){

            $model = new RelatedDownload();
            $model->title = $value['title'];
            $model->url = $value['url'];

            $data->content->related_downloads()->save($model);
        }

    }




}
