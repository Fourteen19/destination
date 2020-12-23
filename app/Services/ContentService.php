<?php

namespace App\Services;

use App\Models\Content;
use App\Models\ContentLive;
use App\Models\RelatedLink;
use App\Models\RelatedVideo;
use App\Models\RelatedDownload;

Class ContentService
{


    public function makeLive($content)
    {

        try
        {
            $now = date('Y-m-d H:i:s');

            $contentData = $content->toArray();

            //gets the content
            $contentLive = ContentLive::where('id', $contentData['id'])->first();

            //set the new type to live
            $contentData['contentable_type'] = $contentData['contentable_type'] . "Live";



            //if the content exists
            if ($contentLive !== null) {

                //do an update
                $contentLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $contentLive->updated_at = $now;
                unset($contentData['updated_at']);
                $contentLive->update($contentData);

                $content->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $content->updated_at = $now;
                $content->save();

            } else {

                //create the content
                $contentLive = ContentLive::create($contentData);

                $contentLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $contentLive->updated_at = $now;
                $contentLive->save();

                $content->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $content->updated_at = $now;
                $content->save();
            }


            //gets the contentable data
            $contentableData = $content->contentable;



            // $entity is the name of the template class
            // App\Models\ContentArticle
            // $entity id the class we target depending on the template selected
            $entity = $content->contentable_type."Live";

            //row id
            $id = $content->contentable->id;

            //gets the article content
            $articleContentLive = \App\Models\ContentAccordionLive::where('id', $id)->first();

            //converts the contentable data to an array
            $contentData = $contentableData->toArray();

            //if the content already exists in the DB
            if ($articleContentLive !== null) {

                //do an update
                $articleContentLive->update($contentData);

            //else if new content
            } else {

                //create the article content
                $articleContentLive = $entity::create($contentData);

            }



            $contentYearGroupsTags = $content->tagsWithType('year');
            $contentLive->syncTagsWithType($contentYearGroupsTags, 'year');

            $contentLscsTags = $content->tagsWithType('career_readiness');
            $contentLive->syncTagsWithType($contentLscsTags, 'career_readiness');

            $contentRoutesTags = $content->tagsWithType('route');
            $contentLive->syncTagsWithType($contentRoutesTags, 'route');

            $contentSectorsTags = $content->tagsWithType('sector');
            $contentLive->syncTagsWithType($contentSectorsTags, 'sector');

            $contentSubjectTags = $content->tagsWithType('subject');
            $contentLive->syncTagsWithType($contentSubjectTags, 'subject');

            $contentFlagTags = $content->tagsWithType('flag');
            $contentLive->syncTagsWithType($contentFlagTags, 'flag');

            $contentTermTags = $content->tagsWithType('term');
            $contentLive->syncTagsWithType($contentTermTags, 'term');


            //saves the videos
            //gets the videos attached to the content
            $contentRelatedVideos = $content->relatedVideos->toArray();

            //delete all videos attached to the live content
            $contentLive->relatedVideos()->delete();

            foreach($contentRelatedVideos as $key => $item){

                $model = new RelatedVideo();
                $model->url = $item['url'];

                $contentLive->relatedVideos()->save($model);
            }



            //saves the related Links
            //gets the related Links attached to the content
            $contentRelatedLinks = $content->relatedLinks->toArray();

            //delete all videos attached to the live content
            $contentLive->relatedLinks()->delete();

            foreach($contentRelatedLinks as $key => $item){

                $model = new RelatedLink();
                $model->title = $item['title'];
                $model->url = $item['url'];

                $contentLive->relatedLinks()->save($model);
            }


            //saves the related downloads
            //gets the related downloads attached to the content
            $contentRelatedDownloads = $content->relatedDownloads->toArray();

            //delete all videos attached to the live content
            $contentLive->relatedDownloads()->delete();

            foreach($contentRelatedDownloads as $key => $item){

                $model = new RelatedDownload();
                $model->title = $item['title'];
                $model->url = $item['url'];

                $contentLive->relatedDownloads()->save($model);
            }

        } catch (exception $e) {

            return false;

        }

        return true;

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Content $content
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Content $content)
    {

        try
        {

            $contentData = $content->toArray();

            $contentLive = ContentLive::where('id', $contentData['id'])->first();

            //tags are automatically removed

            //delete all videos attached to the live content
            $contentLive->relatedDownloads()->delete();

            //delete all links attached to the live content
            $contentLive->relatedLinks()->delete();

            //delete all downloads attached to the live content
            $contentLive->relatedVideos()->delete();

            //gets the contentable data
            $contentLive->contentable->delete();

            $contentLive->forceDelete();

        } catch (exception $e) {

            return false;

        }

        return true;
    }



    public function delete(Content $content)
    {

        try
        {
            //removes the content from the live site
            $this->removeFromlive($content);

            //removes the content
            $content->delete();

        } catch (exception $e) {

            return false;

        }

        return true;
    }


    /**
     * Remove the specified resource from the live site
     *
     * @param  \App\Models\Content $content
     * @return boolean
     */
    public function removeFromlive(Content $content){

        try
        {

            $contentData = $content->toArray();

            $contentLive = ContentLive::where('id', $contentData['id'])->first();

            if ($contentLive)
            {

                //delete all videos attached to the live content
                $contentLive->relatedVideos()->delete();

                //delete all links attached to the live content
                $contentLive->relatedLinks()->delete();

                //delete all downloads attached to the live content
                $contentLive->relatedDownloads()->delete();

                //gets the contentable data
                $contentLive->contentable->delete();

                $contentLive->forceDelete();

            }

        } catch (exception $e) {

            return false;

        }

        return true;
    }


    /*****/


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


        // Attach videos
        $this->saveRelatedVideos($data);

        // Attach links
        $this->saveRelatedLinks($data);

        // Attach downloads
        $this->saveRelatedDownloads($data);


        return $content;

    }



    public function resetAllContentTags($data)
    {

        $data->content->syncTagsWithType([], 'year');
        $data->content->syncTagsWithType([], 'route');
        $data->content->syncTagsWithType([], 'career_readiness');
        $data->content->syncTagsWithType([], 'sector');
        $data->content->syncTagsWithType([], 'subject');
        $data->content->syncTagsWithType([], 'flag');
        $data->content->syncTagsWithType([], 'term');

    }




    public function attachTags($data)
    {

        $data->content->attachTags( !empty($data->contentYearGroupsTags) ? $data->contentYearGroupsTags : [] , 'year' );
        $data->content->attachTags( !empty($data->contentLscsTags) ? $data->contentLscsTags : [] , 'career_readiness' );
        $data->content->attachTags( !empty($data->contentRoutesTags) ? $data->contentRoutesTags : [] , 'route' );
        $data->content->attachTags( !empty($data->contentSectorsTags) ? $data->contentSectorsTags : [] , 'sector' );
        $data->content->attachTags( !empty($data->contentSubjectTags) ? $data->contentSubjectTags : [] , 'subject' );
        $data->content->attachTags( !empty($data->contentFlagTags) ? $data->contentFlagTags : [] , 'flag' );
        $data->content->attachTags( !empty($data->contentTermTags) ? $data->contentTermTags : [] , 'term' );

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



    public function saveRelatedVideos($data)
    {
        //delete all existing videos
        $data->content->relatedVideos()->delete();

        //if related videos exists in the template
        if (isset($data->relatedVideos)){

            //create the videos to attach to content
            foreach($data->relatedVideos as $key => $value){

                $model = new relatedVideo();
                $model->url = $value['url'];

                $data->content->relatedVideos()->save($model);
            }

        }

    }



    public function saveRelatedLinks($data)
    {

        //delete all existing links
        $data->content->relatedLinks()->delete();

        //if related links exists in the template
        if (isset($data->relatedLinks)){

            //create the links to attach to content
            foreach($data->relatedLinks as $key => $value){

                $model = new RelatedLink();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $data->content->relatedLinks()->save($model);
            }

        }

    }



    public function saveRelatedDownloads($data)
    {

        //delete all existing downloads
        $data->content->relatedDownloads()->delete();

        //if related downloads exists in the template
        if (isset($data->relatedLinks)){

            //create the downloads to attach to content
            foreach($data->relatedDownloads as $key => $value){

                $model = new RelatedDownload();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $data->content->relatedDownloads()->save($model);
            }

        }

    }

}
