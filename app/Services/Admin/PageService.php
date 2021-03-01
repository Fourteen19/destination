<?php

namespace App\Services\Admin;

use App\Models\Page;
use Ramsey\Uuid\Uuid;
use App\Models\PageLive;
use App\Models\PageHomepage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;



Class PageService{


    public function getPageDetails($pageRef)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $pageRef ))
        {
            //if global admin
            if (isGlobalAdmin()){
                $page = Page::where('uuid', '=', $pageRef)->get()->first();

            //else if client page
            } else if ( (isClientAdmin()) || (isClientAdvisor()) ) {
                $page = Page::where('uuid', '=', $pageRef)->BelongsToClientScope()->get()->first();

            //else
            } else {
                abort(401);
            }

        } else {
            abort(404);
        }

        return $page;

    }




    /**
     * getHomepageDetails
     * return the homepage. Slection ids done by the slug
     *
     * @return void
     */
    public function getHomepageDetails()
    {
        return Page::where('slug', '=', 'home')->get()->first();
    }




    public function getSummaryPageDetails($pageRef)
    {

        $data = PageLive::select('id')->where('uuid', '=', $pageRef)->get()->first();

    }

    /**
     * getAllClientPagesforDropdown
     * return an array of Uuid => name
     *
     * @return void
     */
    public function getAllClientPagesforDropdown()
    {
        return PageLive::where('pageable_type', '!=', 'App\Models\PageHomepageLive')->orderBy('title', 'ASC')->get()->pluck('title', 'uuid')->toArray();
    }



    public function getLivePageIdByUuid($pageRef)
    {

        if (!empty($pageRef))
        {
            $data = PageLive::select('id')->where('uuid', '=', $pageRef)->get()->first();
            return $data['id'];
        }

        return NULL;
    }



    public function getLivePageUuidById($pageRef)
    {

        if (!empty($pageRef))
        {
            $data = PageLive::select('uuid')->where('id', '=', $pageRef)->get()->first();
            return $data['uuid'];
        }

        return NULL;
    }




    public function getLivePageDetailsByUuid($pageRef)
    {

        if (!empty($pageRef))
        {
            $data = PageLive::select('slug')->where('uuid', '=', $pageRef)->get()->first();
            return $data;
        }

        return NULL;
    }







    public function makeLive($page)
    {
/*
        try
        {
*/            $now = date('Y-m-d H:i:s');

            $pageData = $page->toArray();

            //gets the page
            $pageLive = PageLive::where('id', $pageData['id'])->first();

            //set the new type to live
            $pageData['pageable_type'] = $pageData['pageable_type'] . "Live";

            //if the page exists
            if ($pageLive !== null) {

                //do an update
                $pageLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $pageLive->updated_at = $now;
                unset($pageData['updated_at']);

                $pageLive->update($pageData);

                $page->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $page->updated_at = $now;
                $page->save();

            } else {

                //create the page
                $pageLive = PageLive::create($pageData);

                $pageLive->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $pageLive->updated_at = $now;
                $pageLive->save();

                $page->timestamps = false; //do not update the updated_at timestamp and use our custom date
                $page->updated_at = $now;
                $page->save();

            }


            //gets the pageable data
            $pageableData = $page->pageable;


            // $entity is the name of the template class
            // App\Models\PageStandard
            // $entity id the class we target depending on the template selected
            $entity = $page->pageable_type."Live";

            //row id
            $id = $page->pageable->id;

            //gets the  page
            $pageTypeLive = $entity::where('id', $id)->first();

            //converts the pageable data to an array
            $pageData = $pageableData->toArray();

            //if the page already exists in the DB
            if ($pageTypeLive !== null) {

                //do an update
                $pageTypeLive->update($pageData);

            //else if new page
            } else {

                //create the page
                $pageTypeLive = $entity::create($pageData);

            }

            $this->makeBannerImageLive($page, $pageLive);

/*
        } catch (\Exception $e) {

            return false;

        }
*/
        return true;

    }







    /**
     * makeBannerImageLive
     * gets first image from collection
     * assign image to 'banner' collection
     *
     * @param  mixed $page
     * @param  mixed $pageLive
     * @return void
     */
    public function makeBannerImageLive($page, $pageLive)
    {

        $pageLive->clearMediaCollection('banner');

        $image = $page->getMedia('banner')->first();

        if ($image)
        {

            $copiedMediaItem = $image->copy($pageLive, 'banner', 'media');
//        $this->addMediaToContent($image, 'banner', $pageLive, True);

        }
    }



    /**
     * addMediaToContent
     * clears collection if required
     * assign image to the page
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $page
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToContent($image, $type, $page, $clearCollection=False)
    {
        if ($clearCollection)
        {
            $page->clearMediaCollection($type);
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

            $page->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties(['folder' => $imagePath ])
                        ->toMediaCollection($type);
        }

    }



    public function removeLive(Page $page)
    {

        try
        {

            $pageData = $page->toArray();

            $pageLive = PageLive::where('id', $pageData['id'])->first();

            //gets the pageable data
            $pageLive->pageable->delete();

            $pageLive->forceDelete();

        } catch (\Exception $e) {

            return False;

        }

        return true;
    }



    public function delete(Page $page)
    {

        try
        {
            //removes the page from the live site
            $this->removeFromlive($page);

            //removes the page
            $page->delete();

        } catch (\Exception $e) {

            return false;

        }

        return true;
    }



    public function removeFromlive(Page $page){

        try
        {

            $pageData = $page->toArray();

            $pageLive = PageLive::where('id', $pageData['id'])->first();

            if ($pageLive)
            {

                //gets the pageable data
                $pageLive->pageable->delete();

                $pageLive->forceDelete();

            }

        } catch (\exception $e) {

            return false;

        }

        return true;
    }


    /*****/


    public function storeAndMakeLive($data)
    {

        $page = $this->store($data);

        $this->makeLive($page);

    }




    public function store($data)
    {

        if ($data->action == 'create')
        {

            $page = $this->storeLivewire($data);


        } elseif ($data->action == 'edit'){

            $page = $this->editLivewire($data);

        }

        //attaches media to page
        $this->addMediaToContent($data->banner, 'banner', $page, True);

        return $page->refresh(); // reloads the models with all it new properties

    }




}
