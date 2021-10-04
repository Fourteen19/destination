<?php

namespace App\Services\Admin;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\Vacancy;
use App\Models\Employer;
use App\Models\VacancyLive;
use App\Models\VacancyRole;
use App\Models\relatedVideo;
use App\Models\VacancyRegion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\AdminRequestVacancyAction;
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
            $id = $vacancyLive->id;
          //  dd($id);
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
                'display_until' => !empty($data->display_until) ? Carbon::createFromFormat('d/m/Y', $data->display_until)->format('Y/m/d') : NULL,
                'lead_para' => $data->lead_para,
                'description' => $data->description,
                'entry_requirements' => $data->entry_requirements,
                'role_id' => ($role['id']) ?? NULL,
                'region_id' => ($region['id']) ?? NULL,
                'employer_id' => ($employer['id']) ?? NULL,
                'all_clients' => ($data->all_clients == False) ? "N" : "Y",
                'created_by' => Auth::guard('admin')->user()->id, // about the creator
                'client_id' => Auth::guard('admin')->user()->client_id, // about the creator, will be NULL if created by an employer
            ]);


        } elseif ($data->action == 'edit'){

            $vacancy = Vacancy::where('uuid', $data->vacancyUuid)->firstOrFail();

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
                                'entry_requirements' => $data->entry_requirements,
                                'lead_para' => $data->lead_para,
                                'map' => $data->vac_map,
                                'display_until' => !empty($data->display_until) ? Carbon::createFromFormat('d/m/Y', $data->display_until)->format('Y/m/d') : NULL,
                                'role_id' => $role['id'],
                                'role_id' => ($role['id']) ?? NULL,
                                'region_id' => ($region['id']) ?? NULL,
                                'employer_id' => ($employer['id']) ?? NULL,
                                'all_clients' => ($data->all_clients == False) ? "N" : "Y",
                            ]);


        }


        $allocateClient = [];

        //updates the vacancy depending on the user type
        if (isGlobalAdmin())
        {
            $vacancyData['all_clients'] = ($data->all_clients == 'Y') ? 'Y' : 'N';
            $vacancyData['client_id'] = NULL;


            if (!empty($data->clients)){

                //list of clients to allocate
                $clients = Client::select('id')->whereIn('uuid', $data->clients)->get()->toArray();
                foreach($clients as $client)
                {
                    $allocateClient[] = $client['id'];
                }
            }

        } elseif (isClientAdmin()) {

            $vacancyData['all_clients'] = 'N';
            $vacancyData['client_id'] = Auth::guard('admin')->user()->client_id; //set the client ID of the admin creator
            $allocateClient[] = Auth::guard('admin')->user()->client_id;

        } elseif ( (isClientAdvisor()) || (isClientTeacher( Auth::guard('admin')->user() )) || (isEmployer( Auth::guard('admin')->user() ) ) ) {

            $vacancyData['all_clients'] = 'N';
            $vacancyData['client_id'] = Auth::guard('admin')->user()->client_id; //set the client ID of the admin creator
            $allocateClient[] = Auth::guard('admin')->user()->client_id;

        }


        $this->syncTags($vacancyData, $vacancy);

        $vacancy->clients()->sync($allocateClient);

        $this->attachTags($data, $vacancy);

        // Attach videos
        $this->saveRelatedVideos($vacancy, $data->relatedVideos);

        if ($data->vacancyImage)
        {
            $this->addMediaToVacancy($data, 'vacancy_image', $vacancy, TRUE);

        }

        return $vacancy->refresh();

    }



    public function sendNotificationToAdmin($data)
    {

        //only send email if the admin user is an employer
        //if ( (isEmployer( Auth::guard('admin')->user())) || (isThirdPartyAdmin( Auth::guard('admin')->user())) )
        if (adminHasAnyRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Third_Party_Admin'), config('global.admin_user_type.Employer')]) )
        {

            $role = "";

            if (adminHasRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Third_Party_Admin'), ]) )
            {
                $role = "A third-party admin";
            } elseif (adminHasRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Employer')]) )
            {
                $role = "An employer";
            }

            //if an action is selected
            if ($data->action_requested)
            {

                //send email to admins to let them know the vacancy must go live
                $mailData['email_title'] = $role." is requesting an action from your part";
                $mailData['first_name'] = Auth::guard('admin')->user()->first_name;
                $mailData['title'] = $data->title;
                $mailData['action'] = $data->action_requested;

                //get the list of admin recipients whose job it is to make the vacancies live, not live, delete
                $adminRecipient = app('adminClientContentSettings')->getVacanciesAdminRecipients( Session::get('adminClientSelectorSelected') )->toArray();

                if ($adminRecipient['vacancy_email_notification'])
                {
                    $recipients = explode(';', $adminRecipient['vacancy_email_notification']);

                    Mail::to($recipients)->send(new AdminRequestVacancyAction($mailData));

                } else {

                    //email could not be sent as there is no one to send the notifications to
                    Session::flash('email_fail', 'Your action could not be sent to your administrator');

                }

            }

        }

        return True;

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
     * addMediaToVacancy
     * clears collection if required
     * assign image to the vacancy
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $vacancy
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToVacancy($data, $type, $vacancy, $clearCollection=False)
    {

        //clears the collection for the piece of vacancy
        if ($clearCollection)
        {
            $vacancy->clearMediaCollection($type);
        }


        //if the image passed is an instance of media (ie already saved to DB)
        if ($data->vacancyImage instanceof Media)
        {
            $imagePath = $data->vacancyImage->getCustomProperty('folder');
        //else if media is a string
        } else {
            $imagePath = $data->vacancyImage;
        }

        $properties = ['folder' => $imagePath ];

        //if the image is a banner, we save an alt tag
        if ($type == 'vacancy_image') {
            $properties['alt'] = $data->vacancyImage_alt;
        }


        if ($imagePath)
        {

            $vacancy->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties($properties)
                        ->toMediaCollection($type);
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



    public function syncTags($data, Vacancy $vacancy)
    {

        $vacancy->syncTagsWithType( !empty($data->vacancyYearGroupsTags) ? $data->vacancyYearGroupsTags : [] , 'year' );
        $vacancy->syncTagsWithType( !empty($data->vacancyLscsTags) ? $data->vacancyLscsTags : [] , 'career_readiness' );
        $vacancy->syncTagsWithType( !empty($data->vacancyRoutesTags) ? $data->vacancyRoutesTags : [] , 'route' );
        $vacancy->syncTagsWithType( !empty($data->vacancySectorsTags) ? $data->vacancySectorsTags : [] , 'sector' );
        $vacancy->syncTagsWithType( !empty($data->vacancySubjectTags) ? $data->vacancySubjectTags : [] , 'subject' );
        $vacancy->syncTagsWithType( !empty($data->vacancyFlagTags) ? $data->vacancyFlagTags : [] , 'flag' );
        $vacancy->syncTagsWithType( !empty($data->vacancyTermsTags) ? $data->vacancyTermsTags : [] , 'term' );
        $vacancy->syncTagsWithType( !empty($data->vacancyKeywordTags) ? $data->vacancyKeywordTags : [] , 'keyword' );
        $vacancy->syncTagsWithType( !empty($data->vacancyNeetTags) ? $data->vacancyNeetTags : [] , 'neet' );

    }


    /**
     * getVacancyDetails
     *
     * @param  mixed $uuid
     * @return void
     */
    public function getVacancyDetails($uuid)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $uuid ))
        {

            //if global admin
            if (isGlobalAdmin()){
                $vacancy = Vacancy::where('uuid', '=', $uuid)
                                    ->with('role:id,uuid,name')
                                    ->with('region:id,uuid,name')
                                    ->with('employer:id,uuid,name')
                                    ->firstOrFail();

            //else if client page
            } else {

                if (isClientAdmin()) {
                    $vacancy = Vacancy::where('uuid', '=', $uuid)
                                            ->with('role:id,uuid,name')
                                            ->with('region:id,uuid,name')
                                            ->with('employer:id,uuid,name')
                                            ->leftJoin('clients_vacancies', 'clients_vacancies.vacancy_id', '=', 'vacancies.id')
                                            ->where('vacancies.deleted_at', NULL)
                                            ->where('clients_vacancies.client_id', Auth::guard('admin')->user()->client_id)
                                            ->firstOrFail();

                } elseif (isEmployer(Auth::guard('admin')->user())) {

                    $vacancy = Vacancy::where('uuid', '=', $uuid)
                                        ->with('role:id,uuid,name')
                                        ->with('region:id,uuid,name')
                                        ->with('employer:id,uuid,name')
                                        ->where('created_by', Auth::guard('admin')->user()->id)
                                        ->firstOrFail();
                }
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
    public function removeLive(Vacancy $vacancy)
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
            $this->removeLive($vacancy);

            //removes the content
            $vacancy->delete();

        } catch (\exception $e) {

            return false;

        }

        return true;
    }


}
