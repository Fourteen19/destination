<?php

namespace App\Services\Admin;

use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\relatedVideo;
use App\Models\Vacancy;
use App\Models\Employer;
use App\Models\VacancyLive;
use App\Models\VacancyRole;
use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

Class VacancyService
{


    public function makeLive($vacancy)
    {


            $now = date('Y-m-d H:i:s');

            $vacancyData = $vacancy->toArray();

            //gets the live vacancy if it exists. Load the live vacancy if set as deleted as well
            $vacancyLive = VacancyLive::where('id', $vacancyData['id'])->withTrashed()->first();

            //if the vacancy exists
            if ($vacancyLive !== null) {

                $action = 'edit';

                $vacancyLive->clearMediaCollection(); // all media will be deleted

                $vacancyLive->update($vacancyData);

            } else {

                $action = 'add';

                //create the vacancy
                $vacancyLive = VacancyLive::create($vacancyData);

            }

            //row id
            $id = $vacancy->id;

            $vacancyYearGroupsTags = $vacancy->tagsWithType('year');
            $vacancyLive->syncTagsWithType($vacancyYearGroupsTags, 'year');

            $vacancyLscsTags = $vacancy->tagsWithType('career_readiness');
            $vacancyLive->syncTagsWithType($vacancyLscsTags, 'career_readiness');

            $vacancyRoutesTags = $vacancy->tagsWithType('route');
            $vacancyLive->syncTagsWithType($vacancyRoutesTags, 'route');

            $vacancySectorsTags = $vacancy->tagsWithType('sector');
            $vacancyLive->syncTagsWithType($vacancySectorsTags, 'sector');

            $vacancySubjectTags = $vacancy->tagsWithType('subject');
            $vacancyLive->syncTagsWithType($vacancySubjectTags, 'subject');

            $vacancyFlagTags = $vacancy->tagsWithType('flag');
            $vacancyLive->syncTagsWithType($vacancyFlagTags, 'flag');

            $vacancyTermTags = $vacancy->tagsWithType('term');
            $vacancyLive->syncTagsWithType($vacancyTermTags, 'term');

            $vacancyTermTags = $vacancy->tagsWithType('keyword');
            $vacancyLive->syncTagsWithType($vacancyTermTags, 'keyword');

            $vacancyNeetTags = $vacancy->tagsWithType('neet');
            $vacancyLive->syncTagsWithType($vacancyNeetTags, 'neet');

            //saves the videos
            //gets the videos attached to the content
            $vacancyRelatedVideos = $vacancy->relatedVideos->toArray();
            $this->saveRelatedVideos($vacancyLive, $vacancyRelatedVideos);

            $vacancyClients = $vacancy->clients->toArray();

            $this->saveClients($vacancyLive, $vacancyClients);

            $this->makeMediaImageLive($vacancy, $vacancyLive, 'employer_logo');

            $this->makeMediaImageLive($vacancy, $vacancyLive, 'vacancy_image');



        return true;

    }




    public function saveClients($vacancyLive, $clients)
    {

        $vacancyClients = [];
        foreach($clients as $client)
        {
            $vacancyClients[] = $client['id'];
        }

        $vacancyLive->clients()->sync($vacancyClients);

    }




    /**
     * storeAndMakeLive
     *
     * @param  mixed $data
     * @return void
     */
    public function storeAndMakeLive($data)
    {

        $vacancy = $this->store($data);

        $this->makeLive($vacancy);

    }



    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data)
    {

        $role = VacancyRole::select('id')->where('uuid', $data->role_type)->first()->toArray();
        $region = VacancyRegion::select('id')->where('uuid', $data->region)->first()->toArray();
        $employer = Employer::select('id')->where('uuid', $data->employer)->first()->toArray();

        if ($data->action == 'add')
        {

            //create the `article` record
            $vacancy = Vacancy::create([
                'title' => $data->title,
                'slug' => $data->slug,
                'contact_name' => $data->contact_name,
                'contact_number' => $data->contact_number,
                'contact_email' => $data->contact_email,
                'contact_link' => $data->contact_link,
                'online_link' => $data->online_link,
                'map' => $data->vac_map,
                'lead_para' => $data->lead_para,
                'description' => $data->description,
                'role_id' => ($role['id']) ?? NULL,
                'region_id' => ($region['id']) ?? NULL,
                'employer_id' => ($employer['id']) ?? NULL,
                'all_clients' => ($data->all_clients == False) ? "N" : "Y",
                'created_by' => Auth::guard('admin')->user()->id,
            ]);


        } elseif ($data->action == 'edit'){

            $vacancy = Vacancy::where('uuid', $data->ref)->firstOrFail();

            //updates the resource
            $e = $vacancy->update([
                                'title' => $data->title,
                                'slug' => $data->slug,
                                'contact_name' => $data->contact_name,
                                'contact_number' => $data->contact_number,
                                'contact_email' => $data->contact_email,
                                'contact_link' => $data->contact_link,
                                'online_link' => $data->online_link,
                                'description' => $data->description,
                                'lead_para' => $data->lead_para,
                                'map' => $data->vac_map,
                                'role_id' => $role['id'],
                                'role_id' => ($role['id']) ?? NULL,
                                'region_id' => ($region['id']) ?? NULL,
                                'employer_id' => ($employer['id']) ?? NULL,
                                'all_clients' => ($data->all_clients == False) ? "N" : "Y",
                            ]);


        }

        //updates the event depending on the user type
        if (isGlobalAdmin())
        {
            $vacancyData['all_clients'] = ($data->all_clients == 'Y') ? 'Y' : 'N';
            $vacancyData['client_id'] = NULL;

        } elseif (isClientAdmin()) {

            $vacancyData['all_clients'] = 'N';
            $vacancyData['client_id'] = Auth::guard('admin')->user()->client_id;

        } elseif ( (isClientAdvisor()) || (isClientTeacher()) || (isEmployer())) {

            $vacancyData['all_clients'] = 'N';
            $vacancyData['client_id'] = Auth::guard('admin')->user()->client_id;

        }



        $allocateClient = [];
        if (!empty($data->clients)){

            //list of clients to allocate
            $clients = Client::select('id')->whereIn('uuid', $data->clients)->get()->toArray();
            $allocateClient = [];
            foreach($clients as $client)
            {
                $allocateClient[] = $client['id'];
            }
        }
        $vacancy->clients()->sync($allocateClient);

        $this->attachTags($data, $vacancy);

        // Attach videos
        $this->saveRelatedVideos($vacancy, $data->relatedVideos);

        if ($data->vacancyImage)
        {
            $this->addMediaToVacancy($data->vacancyImage, 'vacancy_image', $vacancy, TRUE);
        }

        return $vacancy;

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



    /**
     * makeBannerImageLive
     * gets first image from collection
     * assign image to 'banner' collection
     *
     * @param  mixed $vacancy
     * @param  mixed $vacancyLive
     * @return void
     */
    public function makeMediaImageLive($vacancy, $vacancyLive, $type)
    {

        $vacancyLive->clearMediaCollection($type);

        $image = $vacancy->getMedia($type)->first();

        if ($image)
        {

            $copiedMediaItem = $image->copy($vacancyLive, $type, 'media');

        }
    }



    /**
     * addMediaToContent
     * clears collection if required
     * assign image to the vacancy
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $vacancy
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToVacancy($image, $type, $vacancy, $clearCollection=False)
    {

        //clears the collection for the piece of vacancy
        if ($clearCollection)
        {
            $vacancy->clearMediaCollection($type);
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

            $vacancy->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties($properties)
                        ->toMediaCollection($type);
        }

    }



    public function attachTags($data, Vacancy $vacancy)
    {

        $vacancy->attachTags( !empty($data->vacancyYearGroupsTags) ? $data->vacancyYearGroupsTags : [] , 'year' );
        $vacancy->attachTags( !empty($data->vacancyLscsTags) ? $data->vacancyLscsTags : [] , 'career_readiness' );
        $vacancy->attachTags( !empty($data->vacancyRoutesTags) ? $data->vacancyRoutesTags : [] , 'route' );
        $vacancy->attachTags( !empty($data->vacancySectorsTags) ? $data->vacancySectorsTags : [] , 'sector' );
        $vacancy->attachTags( !empty($data->vacancySubjectTags) ? $data->vacancySubjectTags : [] , 'subject' );
        $vacancy->attachTags( !empty($data->vacancyFlagTags) ? $data->vacancyFlagTags : [] , 'flag' );
        $vacancy->attachTags( !empty($data->vacancyTermsTags) ? $data->vacancyTermsTags : [] , 'term' );
        $vacancy->attachTags( !empty($data->vacancyKeywordTags) ? $data->vacancyKeywordTags : [] , 'keyword' );
        $vacancy->attachTags( !empty($data->vacancyNeetTags) ? $data->vacancyNeetTags : [] , 'neet' );

    }


    /**
     * getVacancyDetails
     *
     * @param  mixed $ref
     * @return void
     */
    public function getVacancyDetails($ref)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $ref ))
        {

            //if global admin
            if (isGlobalAdmin()){
                $vacancy = Vacancy::where('uuid', '=', $ref)->with('role:id,uuid')->with('region:id,uuid')->firstOrFail();

            //else if client page
            } else {
                $vacancy = Vacancy::where('uuid', '=', $ref)->ForClient( Auth::guard('admin')->user()->client_id)->firstOrFail();

            }

        } else {
            abort(404);
        }

        return $vacancy;

    }




    /**
     * removeFromlive
     *
     * @param  mixed $content
     * @return void
     */
    public function removelive(Vacancy $vacancy)
    {

        try
        {

            $vacancyData = $vacancy->toArray();

            $vacancyLive = VacancyLive::where('id', $vacancyData['id'])->first();

            //tags are automatically removed

            if ($vacancyLive)
            {

                //delete all videos attached to the live content
                $vacancyLive->relatedVideos()->delete();

                //when removing from live we tag the live content record as deleted
                //we can not physically remove it from the table because of database contraints ( users have scores against the content)
                $vacancyLive->delete();

            }

        } catch (\exception $e) {

            return False;

        }

        return true;
    }



    /**
     * delete
     *
     * @param  mixed $vacancy
     * @return void
     */
    public function delete(Vacancy $vacancy)
    {

        try
        {
            //removes the content from the live site
            $this->removelive($vacancy);

            //removes the content
            $vacancy->delete();

        } catch (\exception $e) {

            return false;

        }

        return true;
    }


}
