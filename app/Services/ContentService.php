<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\RelatedVideo;
use App\Models\Content;
use App\Models\ContentLive;
use App\Models\RelatedLink;
use App\Models\ContentArticle;
use App\Models\ContentTemplate;
use App\Models\RelatedDownload;
use App\Models\ContentArticleLive;


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


            //if the content is an article
            if ($content->contentable_type == "App\Models\ContentArticle")
            {

                //gets the article content
                $articleContentLive = ContentArticleLive::where('id', $contentData['id'])->first();

                $contentData = $contentableData->toArray();

                //if the content exists
                if ($articleContentLive !== null) {

                    //do an update
                    $articleContentLive->update($contentData);

                } else {

                    //create the article content
                    $articleContentLive = ContentArticleLive::create($contentData);

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

                $contentSubjectTags = $content->tagsWithType('flag');
                $contentLive->syncTagsWithType($contentSubjectTags, 'flag');

                //do the videos
                //gets the videos attached to the content
                $contentRelatedVideos = $content->relatedVideos->toArray();

                //delete all videos attached to the live content
                $contentLive->relatedVideos()->delete();

                foreach($contentRelatedVideos as $key => $item){

                    $model = new RelatedVideo();
                    $model->url = $item['url'];

                    $contentLive->relatedVideos()->save($model);
                }



                //do the related Links
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


                //do the related downloads
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

}
