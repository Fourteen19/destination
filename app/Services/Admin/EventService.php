<?php

namespace App\Services\Admin;

use Carbon\Carbon;
use App\Models\Event;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\EventLive;
use App\Models\Institution;
use App\Models\RelatedLink;
use App\Models\RelatedVideo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

Class EventService
{


    public function makeLive($event)
    {

        try
        {

            $now = date('Y-m-d H:i:s');

            $eventData = $event->toArray();

            //gets the live event if it exists. Load the live event if set as deted as well
            $eventLive = EventLive::where('id', $eventData['id'])->withTrashed()->first();



            //if the event exists
            if ($eventLive !== null) {

                $action = 'edit';

                $eventLive->clearMediaCollection(); // all media will be deleted

                //do an update
                $eventLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $eventLive->updated_at = $now;
                $eventLive->deleted_at = NULL;
                unset($eventData['updated_at']);
                $eventLive->update($eventData);

                $event->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $event->updated_at = $now;
                $event->save();

            } else {

                $action = 'add';

                //create the event
                $eventLive = EventLive::create($eventData);

               /*  $eventLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $eventLive->updated_at = $now; */
                $eventLive->save();

                $event->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $event->updated_at = $now;
                $event->save();

            }



            //row id
            $id = $event->id;




            $eventYearGroupsTags = $event->tagsWithType('year');
            $eventLive->syncTagsWithType($eventYearGroupsTags, 'year');

            $eventLscsTags = $event->tagsWithType('career_readiness');
            $eventLive->syncTagsWithType($eventLscsTags, 'career_readiness');

            $eventRoutesTags = $event->tagsWithType('route');
            $eventLive->syncTagsWithType($eventRoutesTags, 'route');

            $eventSectorsTags = $event->tagsWithType('sector');
            $eventLive->syncTagsWithType($eventSectorsTags, 'sector');

            $eventSubjectTags = $event->tagsWithType('subject');
            $eventLive->syncTagsWithType($eventSubjectTags, 'subject');

            $eventFlagTags = $event->tagsWithType('flag');
            $eventLive->syncTagsWithType($eventFlagTags, 'flag');

            $eventTermTags = $event->tagsWithType('term');
            $eventLive->syncTagsWithType($eventTermTags, 'term');

            $eventTermTags = $event->tagsWithType('keyword');
            $eventLive->syncTagsWithType($eventTermTags, 'keyword');

            $eventNeetTags = $event->tagsWithType('neet');
            $eventLive->syncTagsWithType($eventNeetTags, 'neet');


            //saves the videos
            //gets the videos attached to the event
            $eventRelatedVideos = $event->relatedVideos->toArray();
            $this->saveRelatedVideos($eventLive, $eventRelatedVideos);

            //saves the related Links
            //gets the related Links attached to the event
            $eventRelatedLinks = $event->relatedLinks->toArray();
            $this->saveRelatedLinks($eventLive, $eventRelatedLinks);

            $eventInstitutions = $event->institutions->toArray();
            $this->saveInstitutions($eventLive, $eventInstitutions);


            $this->makeMediaImageLive($event, $eventLive, 'banner');

            $this->makeMediaImageLive($event, $eventLive, 'summary');


            $this->makeSupportingDownloadsLive($event, $eventLive);

            $this->makeSupportingImagesLive($event, $eventLive);


        } catch (\exception $e) {

            return false;

        }

        return true;

    }



    public function saveInstitutions($eventLive, $eventInstitutions)
    {

        $institutionsList = [];
        foreach($eventInstitutions as $institution)
        {
            $institutionsList[] = $institution['id'];
        }

        $eventLive->institutions()->sync($institutionsList);

    }



    /**
     * addMediaToContent
     * clears collection if required
     * assign image to the content
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $event
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToContent($data, $type, $event, $clearCollection=False)
    {

        //clears the collection for the piece of event
        if ($clearCollection)
        {
            $event->clearMediaCollection($type);
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

            $event->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties($properties)
                        ->toMediaCollection($type);
        }

    }



    /**
     * storeAndMakeLive
     *
     * @param  mixed $data
     * @return void
     */
    public function storeAndMakeLive($data)
    {

        $event = $this->store($data);

        $this->makeLive($event);

    }



    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data)
    {
        //the event is not for specific institution(s)
        $data->institution_specific = 'N';
//dd($data->client);

        if ($data->client == NULL){
            $data->client = "";
        }


        //list of institutions to allocate
        $institutionsList = [];

        if ( Uuid::isValid( $data->client ))
        {
            $client = Client::select('id')->where('uuid', $data->client)->first()->toArray();
            $clientId = $client['id'];

            //if any institution was selected
            if (!empty($data->institutions))
            {

                //gets the institutions Ids based on their UUIDs
                $institutions = Institution::select('id')->whereIn('uuid', $data->institutions)->get()->toArray();

                $institutionsList = [];
                foreach($institutions as $institution)
                {
                    $institutionsList[] = $institution['id'];
                }

                //the event is for specific institution(s)
                $data->institution_specific = 'Y';
            }

        } else {
            $clientId = NULL;
        }


        if ($data->action == 'add')
        {

            $eventData = [
                'title' => $data->title,
                'slug' => $data->slug,
                'date' => !empty($data->event_date) ? Carbon::createFromFormat('d/m/Y', $data->event_date)->format('Y/m/d') : NULL,
                'start_time_hour' => (is_null($data->start_time_hour)) ? 0 : $data->start_time_hour,
                'start_time_min' => (is_null($data->start_time_min)) ? 0 : $data->start_time_min,
                'end_time_hour' => (is_null($data->end_time_hour)) ? 0 : $data->end_time_hour,
                'end_time_min' => (is_null($data->end_time_min)) ? 0 : $data->end_time_min,
                'venue_name' => $data->venue_name,
                'town' => $data->town,
                'contact_name' => $data->contact_name,
                'contact_number' => $data->contact_number,
                'contact_email' => $data->contact_email,
                'booking_link' => $data->booking_link,
                'map' => $data->map,
                'lead_para' => $data->lead_para,
                'description' => $data->description,
                'summary_heading' => $data->summary_heading,
                'summary_text' => $data->summary_text,
                'summary_image_type' => $data->summary_image_type,
                'updated_by' => Auth::guard('admin')->user()->id,
                'created_by' => Auth::guard('admin')->user()->id,
            ];

            //updates the event depending on the user type
            if (isGlobalAdmin())
            {
                $eventData['all_clients'] = ($data->all_clients == 'Y') ? 'Y' : 'N';
                $eventData['all_institutions'] = (count($data->institutions) == 0) ? 'Y' : 'N';
                $eventData['client_id'] = (is_numeric($clientId)) ? $clientId : NULL;
                $eventData['institution_specific'] = (count($data->institutions) > 0) ? 'Y' : 'N';

            } elseif (isClientAdmin()) {

                $eventData['all_clients'] = 'N';
                $eventData['all_institutions'] = (count($data->institutions) == 0) ? 'Y' : 'N';
                $eventData['client_id'] = Auth::guard('admin')->user()->client_id;
                $eventData['institution_specific'] = (count($data->institutions) > 0) ? 'Y' : 'N';

            } elseif ( (isClientAdvisor()) || (isClientTeacher()) ) {

                $eventData['all_clients'] = 'N';
                $eventData['all_institutions'] = (count($data->institutions) == 0) ? 'Y' : 'N';
                $eventData['client_id'] = Auth::guard('admin')->user()->client_id;
                $eventData['institution_specific'] = (count($data->institutions) > 0) ? 'Y' : 'N';

            }

            //create the `article` record
            $event = Event::create($eventData);

            //attaches the instituttions
            $event->institutions()->sync($institutionsList);

        } elseif ($data->action == 'edit'){

            //loads the existing event
            $event = Event::where('uuid', $data->ref)->firstOrFail();

            $eventData = [
                'title' => $data->title,
                'slug' => $data->slug,
                'date' => !empty($data->event_date) ? Carbon::createFromFormat('d/m/Y', $data->event_date)->format('Y/m/d') : NULL,
                'start_time_hour' => (is_null($data->start_time_hour)) ? 0 : $data->start_time_hour,
                'start_time_min' => (is_null($data->start_time_min)) ? 0 : $data->start_time_min,
                'end_time_hour' => (is_null($data->end_time_hour)) ? 0 : $data->end_time_hour,
                'end_time_min' => (is_null($data->end_time_min)) ? 0 : $data->end_time_min,
                'venue_name' => $data->venue_name,
                'town' => $data->town,
                'contact_name' => $data->contact_name,
                'contact_number' => $data->contact_number,
                'contact_email' => $data->contact_email,
                'booking_link' => $data->booking_link,
                'map' => $data->map,
                'lead_para' => $data->lead_para,
                'description' => $data->description,
                'summary_heading' => $data->summary_heading,
                'summary_text' => $data->summary_text,
                'summary_image_type' => $data->summary_image_type,
                'updated_by' => Auth::guard('admin')->user()->id,
            ];

            //updates the event depending on the user type
            if (isGlobalAdmin())
            {
                $eventData['all_clients'] = ($data->all_clients == 'Y') ? 'Y' : 'N';
                $eventData['all_institutions'] = (count($data->institutions) == 0) ? 'Y' : 'N';
                $eventData['client_id'] = (is_numeric($clientId)) ? $clientId : NULL;
                $eventData['institution_specific'] = (count($data->institutions) > 0) ? 'Y' : 'N';

            } elseif (isClientAdmin()) {

                $eventData['all_clients'] = 'N';
                $eventData['all_institutions'] = (count($data->institutions) == 0) ? 'Y' : 'N';
                $eventData['client_id'] = Auth::guard('admin')->user()->client_id;
                $eventData['institution_specific'] = (count($data->institutions) > 0) ? 'Y' : 'N';

            } elseif ( (isClientAdvisor()) || (isClientTeacher()) ) {

                $eventData['all_clients'] = 'N';
                $eventData['all_institutions'] = (count($data->institutions) == 0) ? 'Y' : 'N';
                $eventData['client_id'] = Auth::guard('admin')->user()->client_id;
                $eventData['institution_specific'] = (count($data->institutions) > 0) ? 'Y' : 'N';

            }

            //updates the resource
            $event->update($eventData);

            $event->institutions()->sync($institutionsList);
        }

        $this->attachTags($data, $event);

        // Attach videos
        $this->saveRelatedVideos($event, $data->relatedVideos);

        // Attach links
        $this->saveRelatedLinks($event, $data->relatedLinks);

        // Attach downloads
        $this->saveRelatedDownloads($event, $data->relatedDownloads);

        // Attach Images
        $this->saveRelatedImages($event, $data->relatedImages);

        //attaches media to event
        $this->addMediaToContent($data, 'banner', $event, True);


        $this->addMediaToContent($data, 'summary', $event, True);

        return $event->refresh(); // reloads the models with all it new properties

    }



    /**
     * makeBannerImageLive
     * gets first image from collection
     * assign image to 'banner' collection
     *
     * @param  mixed $event
     * @param  mixed $eventLive
     * @return void
     */
    public function makeMediaImageLive($event, $eventLive, $type)
    {

        $eventLive->clearMediaCollection($type);

        $image = $event->getMedia($type)->first();

        if ($image)
        {

            $copiedMediaItem = $image->copy($eventLive, $type, 'media');

        }
    }



    /**
     * addMediaToContent
     * clears collection if required
     * assign image to the event
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $event
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToEvent($image, $type, $event, $clearCollection=False)
    {

        //clears the collection for the piece of event
        if ($clearCollection)
        {
            $event->clearMediaCollection($type);
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
        if ($imagePath)
        {

            $event->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties($properties)
                        ->toMediaCollection($type);
        }

    }




    /**
     * resetAllContentTags
     *
     * @param  mixed $data
     * @return void
     */
/*     public function resetAllContentTags($data)
    {

        $data->event->syncTagsWithType([], 'year');
        $data->event->syncTagsWithType([], 'route');
        $data->event->syncTagsWithType([], 'career_readiness');
        $data->event->syncTagsWithType([], 'sector');
        $data->event->syncTagsWithType([], 'subject');
        $data->event->syncTagsWithType([], 'flag');
        $data->event->syncTagsWithType([], 'term');
        $data->event->syncTagsWithType([], 'keyword');
        $data->event->syncTagsWithType([], 'neet');

    } */




    public function attachTags($data, Event $event)
    {

        $event->attachTags( !empty($data->eventYearGroupsTags) ? $data->eventYearGroupsTags : [] , 'year' );
        $event->attachTags( !empty($data->eventLscsTags) ? $data->eventLscsTags : [] , 'career_readiness' );
        $event->attachTags( !empty($data->eventRoutesTags) ? $data->eventRoutesTags : [] , 'route' );
        $event->attachTags( !empty($data->eventSectorsTags) ? $data->eventSectorsTags : [] , 'sector' );
        $event->attachTags( !empty($data->eventSubjectTags) ? $data->eventSubjectTags : [] , 'subject' );
        $event->attachTags( !empty($data->eventFlagTags) ? $data->eventFlagTags : [] , 'flag' );
        $event->attachTags( !empty($data->eventTermsTags) ? $data->eventTermsTags : [] , 'term' );
        $event->attachTags( !empty($data->eventKeywordTags) ? $data->eventKeywordTags : [] , 'keyword' );
        $event->attachTags( !empty($data->eventNeetTags) ? $data->eventNeetTags : [] , 'neet' );

    }


/*     public function syncTags($data)
    {

        $data->event->syncTagsWithType($data->eventYearGroupsTags, 'year');
        $data->event->syncTagsWithType($data->eventLscsTags, 'career_readiness');
        $data->event->syncTagsWithType($data->eventTermsTags, 'term');
        $data->event->syncTagsWithType($data->eventRoutesTags, 'route');
        $data->event->syncTagsWithType($data->eventSectorsTags, 'sector');
        $data->event->syncTagsWithType($data->eventSubjectTags, 'subject');
        $data->event->syncTagsWithType($data->eventKeywordTags, 'keyword');
        $data->event->syncTagsWithType($data->eventNeetTags, 'neet');
        $data->event->syncTagsWithType($data->eventFlagTags, 'flag');

    } */





    public function saveRelatedVideos($event, $relatedVideos)
    {
        //delete all existing videos
        $event->relatedVideos()->delete();

        //if related videos exists in the template
        if (isset($relatedVideos)){

            //create the videos to attach to event
            foreach($relatedVideos as $key => $value){

                $model = new RelatedVideo();
                $model->url = $value['url'];
                $model->title = $value['title'];

                $event->relatedVideos()->save($model);
            }

        }

    }

    public function saveRelatedLinks($event, $relatedLinks)
    {

        //delete all existing links
        $event->relatedLinks()->delete();

        //if related links exists in the template
        if (isset($relatedLinks)){

            //create the links to attach to event
            foreach($relatedLinks as $key => $value){

                $model = new RelatedLink();
                $model->title = $value['title'];
                $model->url = $value['url'];

                $event->relatedLinks()->save($model);
            }

        }

    }



    public function saveRelatedDownloads($event, $relatedDownloads)
    {

        $event->clearMediaCollection('supporting_downloads');

        if (count($relatedDownloads) > 0){

            foreach($relatedDownloads as $key => $value){

                $event->addMedia( public_path($value['url']) )
                        ->preservingOriginal()
                        ->withCustomProperties(['folder' => $value['url'],
                                                'title' => $value['title'] ])
                        ->toMediaCollection('supporting_downloads');

            }

        }

    }



    public function saveRelatedImages($event, $relatedImages)
    {

        $event->clearMediaCollection('supporting_images');

        if (count($relatedImages) > 0){

            foreach($relatedImages as $key => $value){

                $event->addMedia( public_path($value['url']) )
                        ->preservingOriginal()
                        ->withCustomProperties(['folder' => $value['url'],
                                                'title' => $value['title'],
                                                'alt' => $value['alt'] ])
                        ->toMediaCollection('supporting_images');

            }

        }

    }




    /**
     * makeSupportingDownloadsLive
     * Fetches the Draft page's supporting downloads
     * Copy each item and link it to the live event
     *
     * @param  mixed $event
     * @param  mixed $eventLive
     * @return void
     */
    public function makeSupportingDownloadsLive($event, $eventLive)
    {

        $eventLive->clearMediaCollection('supporting_downloads');

        //Fetches the Draft page's supporting downloads
        $items = $event->getMedia('supporting_downloads');

        if ($items)
        {
            //Copy each item and link it to the live event
            foreach($items as $key => $item)
            {
                $copiedMediaItem = $item->copy($eventLive, 'supporting_downloads', 'media');
            }
        }

    }




    /**
     * makeSupportingImagesLive
     * Fetches the Draft page's supporting downloads
     * Copy each item and link it to the live eventLive
     *
     * @param  mixed $event
     * @param  mixed $eventLiveLive
     * @return void
     */
    public function makeSupportingImagesLive($event, $eventLive)
    {
        $eventLive->clearMediaCollection('supporting_images');

        //Fetches the Draft page's supporting images
        $items = $event->getMedia('supporting_images');

        if ($items)
        {

            //Copy each item and link it to the live event
            foreach($items as $key => $item)
            {

                $copiedMediaItem = $item->copy($eventLive, 'supporting_images', 'media');

            }
        }

    }



    /**
     * attachImage
     * attaches the image - no conversion needed for the banner
     *
     * @param  mixed $event
     * @param  mixed $image
     * @return void
     */
/*     public function attachImage($event, $image, $type)
    {
        $event->addMedia( ltrim($image, '/') )->preservingOriginal()->toMediaCollection($type);
    }
 */


    /**
     * getEventDetails
     *
     * @param  mixed $ref
     * @return void
     */
    public function getEventDetails($ref)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $ref ))
        {

            //if global admin
            if (isGlobalAdmin()){
                $event = Event::where('uuid', '=', $ref)->firstOrFail();

            //else if client page
            } else {
                $event = Event::where('uuid', '=', $ref)->ForClient( Auth::guard('admin')->user()->client_id)->firstOrFail();

            }

        } else {
            abort(404);
        }

        return $event;

    }




    /**
     * removeFromlive
     *
     * @param  mixed $event
     * @return void
     */
    public function removelive(Event $event)
    {

        try
        {
            DB::beginTransaction();
            $eventData = $event->toArray();

            $eventLive = EventLive::where('id', $eventData['id'])->first();

            //tags are automatically removed

             if ($eventLive)
            {

                //delete all links attached to the live event
                $eventLive->relatedLinks()->delete();

                //delete all downloads attached to the live event
                $eventLive->relatedVideos()->delete();

                $eventLive->clearMediaCollection('banner');

                $eventLive->clearMediaCollection('supporting_images');

                $eventLive->clearMediaCollection('supporting_downloads');

                $eventLive->clearMediaCollection('summary');

                //when removing from live we tag the live content record as deleted
                //we can not physically remove it from the table because of database contraints ( users have scores against the content)
                $r  = $eventLive->delete();


            }
            DB::commit();
        } catch (\exception $e) {

            return False;

        }

        return true;
    }



    /**
     * delete
     *
     * @param  mixed $event
     * @return void
     */
    public function delete(Event $event)
    {

        try
        {
            //removes the content from the live site
            $this->removelive($event);

            //removes the content
            $event->delete();

        } catch (\exception $e) {

            return false;

        }

        return true;
    }




    /**
     * getLiveEventUuidById
     * Get live event UUID based on the ID
     *
     * @param  mixed $contentRef
     * @return void
     */
    public function getLiveEventUuidById($Uuid)
    {
        if (!empty($Uuid))
        {
            $data = EventLive::select('uuid')->where('id', '=', $Uuid)->get()->first();
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
    public function getLiveContentIdByUuid($Uuid)
    {

        if (!empty($Uuid))
        {
            $data = EventLive::select('id')->where('uuid', '=', $Uuid)->get()->first();

            return $data['id'];
        }

        return NULL;
    }


    /**
     * getSummaryLiveEventIdByUuid
     *
     * @param  mixed $contentRef
     * @return void
     */
    public function getSummaryLiveEventIdByUuid($Uuid)
    {

        if (!empty($Uuid))
        {
            $event = EventLive::where('uuid', '=', $Uuid)->get()->first();

            if (!is_null($event))
            {
                $data = [];
                $data['summary_heading'] = $event->summary_heading;
                $data['summary_text'] = $event->summary_text;
                $data['slug'] = $event->slug;
                $data['summary_image'] = $event->getFirstMediaUrl('summary', 'small');

                return $data;
            }
        }
        return NULL;
    }





    /**
     * getSummaryEventDetailsForPreview
     *
     * @return void
     */
    public function getSummaryEventDetailsForPreview($contentRef)
    {
        if (!empty($contentRef))
        {
            return $this->getSummaryLiveEventIdByUuid($contentRef);

        }

        return NULL;

    }




    public function loadLiveEventById($id)
    {

        if (!empty($id))
        {
            $event = EventLive::where('id', '=', $id)->first();

            if (!is_null($event))
            {
                $data = [];
                $data['summary_heading'] = $event->summary_heading;
                $data['summary_text'] = $event->summary_text;
                $data['slug'] = $event->slug;
                $data['summary_image'] = $event->getFirstMediaUrl('summary', 'small');

                return $data;
            }
        }
        return NULL;

    }

}
