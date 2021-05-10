<?php

namespace App\Services\Admin;

//use App\Models\Content;
use App\Models\Content;
use App\Models\ContentLive;
use App\Models\RelatedLink;
use App\Models\RelatedVideo;
use App\Models\RelatedQuestion;
use Illuminate\Support\Facades\DB;
use App\Models\RelatedActivityQuestion;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

Class ContentService
{

    public function makeLive($content)
    {

        try
        {

            $now = date('Y-m-d H:i:s');

            $contentData = $content->toArray();

            //gets the live content if it exists. Load the live content if set as deted as well
            $contentLive = ContentLive::where('id', $contentData['id'])->withTrashed()->first();

            //set the new type to live
            $contentData['contentable_type'] = $contentData['contentable_type'] . "Live";


            //if the content exists
            if ($contentLive !== null) {

                $action = 'edit';

                $contentLive->clearMediaCollection(); // all media will be deleted

                //do an update
                $contentLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $contentLive->updated_at = $now;
                $contentLive->deleted_at = NULL;
                unset($contentData['updated_at']);
                $contentLive->update($contentData);

                $content->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $content->updated_at = $now;
                $content->save();

            } else {

                $action = 'add';

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

            $contentTermTags = $content->tagsWithType('keyword');
            $contentLive->syncTagsWithType($contentTermTags, 'keyword');

            $contentNeetTags = $content->tagsWithType('neet');
            $contentLive->syncTagsWithType($contentNeetTags, 'neet');


            //saves the videos
            //gets the videos attached to the content
            $contentRelatedVideos = $content->relatedVideos->toArray();
            $this->saveRelatedVideos($contentLive, $contentRelatedVideos);

            //saves the related Links
            //gets the related Links attached to the content
            $contentRelatedLinks = $content->relatedLinks->toArray();
            $this->saveRelatedLinks($contentLive, $contentRelatedLinks);


            //saves the related questions
            //gets the related questions attached to the content
            $contentRelatedQuestions = $content->relatedQuestions->toArray();
            $this->saveRelatedQuestions($contentLive, $contentRelatedQuestions);

            //saves the related activity questions
            //gets the related activity questions attached to the content
            $contentRelatedActivityQuestions = $content->relatedActivityQuestions->toArray();
            $this->saveRelatedActivityQuestionsToLive($contentLive, $contentRelatedActivityQuestions, $action);

            $this->makeBannerImageLive($content, $contentLive);

            $this->makeSummaryImageLive($content, $contentLive);

            $this->makeSupportingDownloadsLive($content, $contentLive);

            $this->makeSupportingImagesLive($content, $contentLive);


        } catch (\exception $e) {

            return false;

        }

        return true;

    }



    /**
     * makeSupportingDownloadsLive
     * Fetches the Draft page's supporting downloads
     * Copy each item and link it to the live content
     *
     * @param  mixed $content
     * @param  mixed $contentLive
     * @return void
     */
    public function makeSupportingDownloadsLive($content, $contentLive)
    {

        $contentLive->clearMediaCollection('supporting_downloads');

        //Fetches the Draft page's supporting downloads
        $items = $content->getMedia('supporting_downloads');

        if ($items)
        {
            //Copy each item and link it to the live content
            foreach($items as $key => $item)
            {
                $copiedMediaItem = $item->copy($contentLive, 'supporting_downloads', 'media');
            }
        }

    }




    /**
     * makeSupportingImagesLive
     * Fetches the Draft page's supporting downloads
     * Copy each item and link it to the live content
     *
     * @param  mixed $content
     * @param  mixed $contentLive
     * @return void
     */
    public function makeSupportingImagesLive($content, $contentLive)
    {
       $contentLive->clearMediaCollection('supporting_images');

        //Fetches the Draft page's supporting images
        $items = $content->getMedia('supporting_images');

        if ($items)
        {

            //Copy each item and link it to the live content
            foreach($items as $key => $item)
            {

                $copiedMediaItem = $item->copy($contentLive, 'supporting_images', 'media');

            }
        }

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
        $contentLive->clearMediaCollection('banner');

        $image = $content->getMedia('banner')->first();

        if ($image)
        {

            $copiedMediaItem = $image->copy($contentLive, 'banner', 'media');

        }
    }

    /**
     * makeSummaryImageLive
     * gets first image from collection
     * assign image to 'summary' collection
     *
     * @param  mixed $content
     * @param  mixed $contentLive
     * @return void
     */
    public function makeSummaryImageLive($content, $contentLive)
    {
        $contentLive->clearMediaCollection('summary');

        $image = $content->getMedia('summary')->first();

        if ($image)
        {

            $copiedMediaItem = $image->copy($contentLive, 'summary', 'media');

        }

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
    public function addMediaToContent($data, $type, $content, $clearCollection=False)
    {

        //clears the collection for the piece of content
        if ($clearCollection)
        {
            $content->clearMediaCollection($type);
        }

        //if we save a summary image
        if ($type == 'summary')
        {
            if ($data->summary_image_type == 'Automatic')
            {
                $image = $data->banner;
            } else {
                $image = $data->summary;
            }

        //if we save a banner
        } elseif ($type == 'banner') {

            $image = $data->banner;

        }


        //if the image passed is an instance of media (ie already saved to DB)
        if ($image instanceof Media)
        {
            $imagePath = $image->getCustomProperty('folder');
        //else if media is a string
        } else {
            $imagePath = $image;
        }



        $properties = ['folder' => $imagePath ];
        //if the image is a banner, we save an alt tag
        if ($type == 'banner') {
            $properties['alt'] = $data->banner_alt;
        }


        if ($imagePath)
        {

            $content->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties($properties)
                        ->toMediaCollection($type);
        }

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

        /* try
        { */

            $contentData = $content->toArray();

            $contentLive = ContentLive::where('id', $contentData['id'])->first();

            //tags are automatically removed

            if ($contentLive)
            {
                //delete all links attached to the live content
                $contentLive->relatedLinks()->delete();

                //delete all downloads attached to the live content
                $contentLive->relatedVideos()->delete();

                //gets the contentable data
                if ($contentLive->contentable)
                {
                    $contentLive->contentable->delete();
                }

                //when removing from live we tag the live content record as deleted
                //we can not physically remove it from the table because of database contraints ( users have scores against the content)
                $contentLive->delete();

            }

        /* } catch (\exception $e) {

            return False;

        } */

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

        } catch (\exception $e) {

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

                //gets the contentable data
                if ($contentLive->contentable)
                {
                    $contentLive->contentable->delete();
                }

                $contentLive->delete();

            }

        } catch (\exception $e) {

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

        if (isset($data->relatedQuestions)){
            // Attach questions
            $this->saveRelatedQuestions($content, $data->relatedQuestions);
        }

        if (isset($data->relatedActivityQuestions)){
            // Attach activity questions
            $this->saveRelatedActivityQuestions($content, $data->relatedActivityQuestions, $data->action);
        }

        // Attach videos
        $this->saveRelatedVideos($content, $data->relatedVideos);

        // Attach links
        $this->saveRelatedLinks($content, $data->relatedLinks);

        // Attach downloads
        $this->saveRelatedDownloads($content, $data->relatedDownloads);

        // Attach Images
        $this->saveRelatedImages($content, $data->relatedImages);

        //attaches media to content
        //$this->addMediaToContent($data->banner, 'banner', $content, True);
        $this->addMediaToContent($data, 'banner', $content, True);


        $this->addMediaToContent($data, 'summary', $content, True);

        return $content->refresh(); // reloads the models with all it new properties

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
        $data->content->syncTagsWithType([], 'keyword');
        $data->content->syncTagsWithType([], 'neet');

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
        $content->attachTags( !empty($data->contentKeywordTags) ? $data->contentKeywordTags : [] , 'keyword' );
        $content->attachTags( !empty($data->contentNeetTags) ? $data->contentNeetTags : [] , 'neet' );

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
        $data->content->syncTagsWithType($data->contentKeywordTags, 'keyword');
        $data->content->syncTagsWithType($data->contentNeetTags, 'neet');
        $data->content->syncTagsWithType($data->contentFlagTags, 'flag');

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
                $model->title = $value['title'];

                $content->relatedVideos()->save($model);
            }

        }

    }



    public function saveRelatedActivityQuestionsToLive($content, $relatedActivityQuestions, $action)
    {

        //if related questions exists in the template
        if (isset($relatedActivityQuestions)){

            //create the questions to attach to content
            foreach($relatedActivityQuestions as $key => $value){

                //loads the live question
                $question = RelatedActivityQuestion::where('order_id', '=', $value['order_id'])
                                            ->where('activquestionable_type', '=', $value['activquestionable_type'].'Live')
                                            ->where('activquestionable_id', '=', $value['activquestionable_id'])
                                            ->first();


                //if the question does not exists
                if (!$question)
                {

                    //create the question
                    $model = new RelatedActivityQuestion();
                    $model->text = $value['text'];
                    $model->order_id = $key + 1;

                    $content->relatedActivityQuestions()->save($model);

                } else {

                    //update the question
                    $question->update(['text' => $value['text']]);

                }

            }

        }
    }





    /**
     * saveRelatedActivityQuestions
     *
     * @param  mixed $content
     * @param  mixed $relatedQuestions
     * @return void
     */
    public function saveRelatedActivityQuestions($content, $relatedActivityQuestions, $action)
    {

        //if related questions exists in the template
        if (isset($relatedActivityQuestions)){

            //create the questions to attach to content
            foreach($relatedActivityQuestions as $key => $value){

                //if no ID is set, we need to create the model and the relationship to the content
                if (is_null($value['id']))
                {

                    $model = new RelatedActivityQuestion();
                    $model->text = $value['text'];
                    $model->order_id = $key + 1;

                    $content->relatedActivityQuestions()->save($model);

                } else {

                    //the $value['id'] is actually the UUID
                    RelatedActivityQuestion::where('uuid', '=', $value['id'])->update(['text' => $value['text']]);
                }

            }

        }

    }



    /**
     * saveRelatedQuestions
     *
     * @param  mixed $content
     * @param  mixed $relatedQuestions
     * @return void
     */
    public function saveRelatedQuestions($content, $relatedQuestions)
    {
        //delete all existing videos
        $content->relatedQuestions()->delete();

        //if related videos exists in the template
        if (isset($relatedQuestions)){

            //create the videos to attach to content
            foreach($relatedQuestions as $key => $value){

                $addToModel = False;

                if ($content instanceof ContentLive)
                {

                   // dd($relatedQuestions);

                    $addToModel = True;
                    //if making live, we do not check the `deleted` flag as it only exists when saving from the add/edit content
                } else {

                    //if the question is not set to `deleted`
                    if ($value['deleted'] == false)
                    {
                        $addToModel = True;
                    }


                }


                //if the question is not set to `deleted`
                if ($addToModel)
                {

                    $model = new RelatedQuestion();
                    $model->title = $value['title'];
                    $model->text = $value['text'];

                    $content->relatedQuestions()->save($model);

                }

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

        $content->clearMediaCollection('supporting_downloads');

        if (count($relatedDownloads) > 0){

            foreach($relatedDownloads as $key => $value){

                $content->addMedia( public_path($value['url']) )
                        ->preservingOriginal()
                        ->withCustomProperties(['folder' => $value['url'],
                                                'title' => $value['title'] ])
                        ->toMediaCollection('supporting_downloads');

            }

        }

    }



    public function saveRelatedImages($content, $relatedImages)
    {

        $content->clearMediaCollection('supporting_images');

        if (count($relatedImages) > 0){

            foreach($relatedImages as $key => $value){

                $content->addMedia( public_path($value['url']) )
                        ->preservingOriginal()
                        ->withCustomProperties(['folder' => $value['url'],
                                                'title' => $value['title'],
                                                'alt' => $value['alt'] ])
                        ->toMediaCollection('supporting_images');

            }

        }

    }




    /**
     * getAllLiveClientArticlesforDropdown
     * gets all the live articles for the dropdowns
     *
     * @return void
     */
    public function getAllLiveClientArticlesforDropdown()
    {
        return ContentLive::orderBy('title', 'ASC')->get()->pluck('title', 'uuid')->toArray();
    }



    /**
     * getLiveContentUuidById
     * Get live content UUID based on the ID
     *
     * @param  mixed $contentRef
     * @return void
     */
    public function getLiveContentUuidById($contentRef)
    {
        if (!empty($contentRef))
        {
            $data = ContentLive::select('uuid')->where('id', '=', $contentRef)->get()->first();
            return $data['uuid'];
        }

        return NULL;
    }


    /**
     * getLivePageIdByUuid
     *
     * @param  mixed $contentRef
     * @return void
     */
    public function getLiveContentIdByUuid($contentRef)
    {

        if (!empty($contentRef))
        {
            $data = ContentLive::select('id')->where('uuid', '=', $contentRef)->get()->first();

            return $data['id'];
        }

        return NULL;
    }





    /**
     * getLivePageIdByUuid
     *
     * @param  mixed $contentRef
     * @return void
     */
    public function getSummaryLiveContentIdByUuid($contentRef)
    {

        if (!empty($contentRef))
        {
            $content = ContentLive::where('uuid', '=', $contentRef)->get()->first();

            if (!is_null($content))
            {
                $data = [];
                $data['summary_heading'] = $content->summary_heading;
                $data['summary_text'] = $content->summary_text;
                $data['slug'] = $content->slug;
                $data['summary_image'] = $content->getFirstMediaUrl('summary', 'summary_slot4-5-6');

                return $data;
            }
        }
        return NULL;
    }



    /**
     * getSummaryPageDetailsForPreview
     *
     * @return void
     */
    public function getSummaryPageDetailsForPreview($contentRef)
    {
        if (!empty($contentRef))
        {
            return $this->getSummaryLiveContentIdByUuid($contentRef);

        }

        return NULL;

    }


    /**
     * attachBanner
     * attaches the banner - no conversion needed for the banner
     *
     * @param  mixed $content
     * @param  mixed $bannerImage
     * @return void
     */
    public function attachBanner($content, $bannerImage)
    {
        $content->addMedia( ltrim($bannerImage, '/') )->preservingOriginal()->toMediaCollection('banner');
    }

}
