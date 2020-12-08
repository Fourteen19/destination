<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Video;
use App\Models\Content;
use App\Models\ContentLive;
use App\Models\RelatedLink;
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

                $contentLscsTags = $content->tagsWithType('lscs');
                $contentLive->syncTagsWithType($contentLscsTags, 'lscs');

                $contentRoutesTags = $content->tagsWithType('route');
                $contentLive->syncTagsWithType($contentRoutesTags, 'route');

                $contentSectorsTags = $content->tagsWithType('sector');
                $contentLive->syncTagsWithType($contentSectorsTags, 'sector');

                $contentSubjectTags = $content->tagsWithType('subject');
                $contentLive->syncTagsWithType($contentSubjectTags, 'subject');



                //do the videos
                //gets the videos attached to the content
                $contentVideos = $content->videos->toArray();

                //delete all videos attached to the live content
                $contentLive->videos()->delete();

                foreach($contentVideos as $key => $contentVideo){

                    $model = new Video();
                    $model->url = $contentVideo['url'];

                    $contentLive->videos()->save($model);
                }



                //do the related Links
                //gets the related Links attached to the content
                $contentRelatedLinks = $content->related_links->toArray();

                //delete all videos attached to the live content
                $contentLive->related_links()->delete();

                foreach($contentRelatedLinks as $key => $contentRelatedLink){

                    $model = new RelatedLink();
                    $model->title = $contentRelatedLink['title'];
                    $model->url = $contentRelatedLink['url'];

                    $contentLive->related_links()->save($model);
                }


                //do the related downloads
                //gets the related downloads attached to the content
                $contentRelatedDownloads = $content->related_links->toArray();

                //delete all videos attached to the live content
                $contentLive->related_downloads()->delete();

                foreach($contentRelatedDownloads as $key => $contentRelatedDownload){

                    $model = new RelatedDownload();
                    $model->title = $contentRelatedDownload['title'];
                    $model->url = $contentRelatedDownload['url'];

                    $contentLive->related_downloads()->save($model);
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
            $contentLive->related_downloads()->delete();

            //delete all videos attached to the live content
            $contentLive->related_links()->delete();

            //delete all videos attached to the live content
            $contentLive->videos()->delete();

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
                $contentLive->related_downloads()->delete();

                //delete all videos attached to the live content
                $contentLive->related_links()->delete();

                //delete all videos attached to the live content
                $contentLive->videos()->delete();

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