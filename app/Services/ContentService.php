<?php

namespace App\Services;

//use App\Models\Content;
use App\Models\Content;
use App\Models\ContentLive;
use App\Models\RelatedLink;
use App\Models\RelatedVideo;
use App\Models\RelatedDownload;
use App\Models\RelatedQuestion;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
//            $articleContentLive = \App\Models\ContentAccordionLive::where('id', $id)->first();
            $articleContentLive = $entity::where('id', $id)->first();

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

            $this->saveRelatedVideos($contentLive, $contentRelatedVideos);

/*
            //delete all videos attached to the live content
            $contentLive->relatedVideos()->delete();

            foreach($contentRelatedVideos as $key => $item){

                $model = new RelatedVideo();
                $model->url = $item['url'];

                $contentLive->relatedVideos()->save($model);
            }
*/


            //saves the related Links
            //gets the related Links attached to the content
            $contentRelatedLinks = $content->relatedLinks->toArray();

            $this->saveRelatedLinks($contentLive, $contentRelatedLinks);
/*
            //delete all videos attached to the live content
            $contentLive->relatedLinks()->delete();

            foreach($contentRelatedLinks as $key => $item){

                $model = new RelatedLink();
                $model->title = $item['title'];
                $model->url = $item['url'];

                $contentLive->relatedLinks()->save($model);
            }
*/

            //saves the related downloads
            //gets the related downloads attached to the content
            $contentRelatedDownloads = $content->relatedDownloads->toArray();

            $this->saveRelatedDownloads($contentLive, $contentRelatedDownloads);
/*
            //delete all videos attached to the live content
            $contentLive->relatedDownloads()->delete();

            foreach($contentRelatedDownloads as $key => $item){

                $model = new RelatedDownload();
                $model->title = $item['title'];
                $model->url = $item['url'];

                $contentLive->relatedDownloads()->save($model);
            }
*/


            //saves the related downloads
            //gets the related downloads attached to the content
            $contentRelatedQuestions = $content->relatedQuestions->toArray();

            $this->saveRelatedQuestions($contentLive, $contentRelatedQuestions);
/*
            //delete all videos attached to the live content
            $contentLive->relatedQuestions()->delete();

            foreach($contentRelatedQuestions as $key => $item){

                $model = new RelatedQuestion();
                $model->title = $item['title'];
                $model->text = $item['text'];

                $contentLive->relatedQuestions()->save($model);
            }
*/
/*
$banner = $content->getMedia('banner')->first();

//if the image passed is an instance of media (ie already saved to DB)
if ($banner instanceof Media)
{
    $imagePath = $banner->getCustomProperty('folder');
//else if media is a string
} else {
    $imagePath = $banner;
}

            $contentLive->clearMediaCollection('banner');
            $contentLive->addMedia(public_path( 'storage' . $imagePath ))
                    ->preservingOriginal()
                    ->withCustomProperties(['folder' => $imagePath ])
                    ->toMediaCollection('banner');
*/


/*            $contentLive->addMedia(public_path( 'storage' . $banner->getCustomProperty('folder') ))
                    ->preservingOriginal()
                    ->withCustomProperties(['folder' => $banner->getCustomProperty('folder') ])
                    ->toMediaCollection('banner');
*/
            //banner



            $this->makeBannerImageLive($content, $contentLive);

            $this->makeSummaryImageLive($content, $contentLive);



        } catch (exception $e) {

            return false;

        }

        return true;

    }


    /**
     * makeBannerImageLive
     * gets first image from collection
     * assign image to 'banner' collection
     *
     * @param  mixed $content
     * @param  mixed $contentLive
     * @return void
     */
    public function makeBannerImageLive($content, $contentLive)
    {
        $image = $content->getMedia('banner')->first();

        $this->addMediaToContent($image, 'banner', $contentLive, True);

    }

    /**
     * makeSummaryImageLive
     * gets first image from collection
     * assign image to 'banner' collection
     *
     * @param  mixed $content
     * @param  mixed $contentLive
     * @return void
     */
    public function makeSummaryImageLive($content, $contentLive)
    {

        $image = $content->getMedia('summary')->first();

        $this->addMediaToContent($image, 'summary', $contentLive, True);

    }



    /**
     * addMediaToContent
     * clears collection if required
     * assign image to the content
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $content
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToContent($image, $type, $content, $clearCollection=False)
    {
        if ($clearCollection)
        {
            $content->clearMediaCollection($type);
        }

        //if the image passed is an instance of media (ie already saved to DB)
        if ($image instanceof Media)
        {
            $imagePath = $image->getCustomProperty('folder');
        //else if media is a string
        } else {
            $imagePath = $image;
        }

        if ($imagePath)
        {

            $content->addMedia(public_path( 'storage' . $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties(['folder' => $imagePath ])
                        ->toMediaCollection($type);
        }

    }

/*
    public function makeBannerLive($content, $contentLive)
    {

        $banner = $content->getMedia('banner')->first();

        $contentLive->clearMediaCollection('banner');

        $contentLive->addMedia(public_path( 'storage' . $banner->getCustomProperty('folder') ))
                    ->preservingOriginal()
                    ->withCustomProperties(['folder' => $banner->getCustomProperty('folder') ])
                    ->toMediaCollection('banner');

    }
*/


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

        // Attach questions
        //$this->saveRelatedQuestions($data->content, $data->relatedQuestions);

        // Attach videos
        $this->saveRelatedVideos($data->content, $data->relatedVideos);

        // Attach links
        $this->saveRelatedLinks($data->content, $data->relatedLinks);

        // Attach downloads
        $this->saveRelatedDownloads($data->content, $data->relatedDownloads);

        //attaches media to content
        $this->addMediaToContent($data->banner, 'banner', $content, True);

        //attaches media to content
        $this->addMediaToContent($data->summary, 'summary', $content, True);

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




    public function attachTags($data, Content $content)
    {

        $content->attachTags( !empty($data->contentYearGroupsTags) ? $data->contentYearGroupsTags : [] , 'year' );
        $content->attachTags( !empty($data->contentLscsTags) ? $data->contentLscsTags : [] , 'career_readiness' );
        $content->attachTags( !empty($data->contentRoutesTags) ? $data->contentRoutesTags : [] , 'route' );
        $content->attachTags( !empty($data->contentSectorsTags) ? $data->contentSectorsTags : [] , 'sector' );
        $content->attachTags( !empty($data->contentSubjectTags) ? $data->contentSubjectTags : [] , 'subject' );
        $content->attachTags( !empty($data->contentFlagTags) ? $data->contentFlagTags : [] , 'flag' );
        $content->attachTags( !empty($data->contentTermsTags) ? $data->contentTermsTags : [] , 'term' );

    }


    public function syncTags($data)
    {
/*
        $this->resetAllContentTags($data);

        $this->attachTags($data);
*/

        $data->content->syncTagsWithType($data->contentYearGroupsTags, 'year');
        $data->content->syncTagsWithType($data->contentLscsTags, 'career_readiness');
        $data->content->syncTagsWithType($data->contentTermsTags, 'term');
        $data->content->syncTagsWithType($data->contentRoutesTags, 'route');
        $data->content->syncTagsWithType($data->contentSectorsTags, 'sector');
        $data->content->syncTagsWithType($data->contentSubjectTags, 'subject');

    }



    public function saveRelatedVideos($content, $relatedVideos)
    {
        //delete all existing videos
        $content->relatedVideos()->delete();

        //if related videos exists in the template
        if (isset($relatedVideos)){

            //create the videos to attach to content
            foreach($relatedVideos as $key => $value){

                $model = new relatedVideo();
                $model->url = $value['url'];

                $content->relatedVideos()->save($model);
            }

        }

    }

/*
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



    public function saveRelatedQuestions($data)
    {
        //delete all existing videos
        $data->content->relatedQuestions()->delete();
//dd($data);
        //if related videos exists in the template
        if (isset($data->relatedQuestions)){

            //create the videos to attach to content
            foreach($data->relatedQuestions as $key => $value){

                $model = new RelatedQuestion();
                $model->title = $value['title'];
                $model->text = $value['text'];

                $data->content->relatedQuestions()->save($model);
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
        if (isset($data->relatedDownloads)){

            //create the downloads to attach to content
            foreach($data->relatedDownloads as $key => $value){

                $model = new RelatedDownload();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $data->content->relatedDownloads()->save($model);
            }

        }

    }

*/
    public function saveRelatedQuestions($content, $relatedQuestions)
    {
        //delete all existing videos
        $content->relatedQuestions()->delete();

        //if related videos exists in the template
        if (isset($relatedQuestions)){

            //create the videos to attach to content
            foreach($relatedQuestions as $key => $value){

                $model = new RelatedQuestion();
                $model->title = $value['title'];
                $model->text = $value['text'];

                $content->relatedQuestions()->save($model);
            }

        }

    }


    public function saveRelatedLinks($content, $relatedLinks)
    {

        //delete all existing links
        $content->relatedLinks()->delete();

        //if related links exists in the template
        if (isset($relatedLinks)){

            //create the links to attach to content
            foreach($relatedLinks as $key => $value){

                $model = new RelatedLink();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $content->relatedLinks()->save($model);
            }

        }

    }



    public function saveRelatedDownloads($content, $relatedDownloads)
    {

        //delete all existing downloads
        $content->relatedDownloads()->delete();

        //if related downloads exists in the template
        if (isset($relatedDownloads)){

            //create the downloads to attach to content
            foreach($relatedDownloads as $key => $value){

                $model = new RelatedDownload();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $content->relatedDownloads()->save($model);
            }

        }

    }


/*
    public function saveBanner($content)
    {

        $content->clearMediaCollection('banner');

        //if a banner has been set in the backend
        if ($data->banner)
        {

            $content->addMedia(public_path( 'storage' . $data->banner))
                ->preservingOriginal()
                ->withCustomProperties(['folder' => $data->banner])
                ->toMediaCollection('banner');

        }

    }


    public function saveSummaryImage($content)
    {

        $content->clearMediaCollection('summary');

        //if a banner has been set in the backend
        if ($data->summary)
        {

            $content->addMedia(public_path( 'storage' . $data->summary))
                ->preservingOriginal()
                ->withCustomProperties(['folder' => $data->summary])
                ->toMediaCollection('summary');

        }

    }
*/





}
