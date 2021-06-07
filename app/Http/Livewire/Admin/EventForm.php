<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Client;
use Livewire\Component;
use Spatie\Image\Image;
use App\Models\SystemTag;
use App\Models\Institution;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\EventService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EventForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['make_banner_image' => 'makeBannerImage',
                            'make_summary_image' => 'makeSummaryImage',
                            'make_related_download' => 'makeRelatedDownload',
                            'make_related_image' => 'makeRelatedImage',
                            'update_videos_order' => 'updateVideosOrder',
                            'update_links_order' => 'updateLinksOrder',
                            'update_downloads_order' => 'updateDownloadsOrder',
                            ];

    public $title, $slug, $event_date, $start_time_hour, $start_time_min, $end_time_hour, $end_time_min, $venue_name, $town;
    public $contact_name, $contact_number, $contact_email, $booking_link;
    public $lead_para, $description, $video, $map, $summary_heading, $summary_text;
    public $action;
    public $ref;
    public $isGlobal = 0;
    public $activeTab;

    public $canMakeEventLive; //admin permission to make the event live
    public $tempImagePath;

    public $banner;
    public $banner_alt;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $summary_image_type;
    public $summary;
    public $summaryOriginal;
    public $summaryImageSlotLargePreview;
    public $summaryImageSlotSmallPreview;
    public $summaryImageIsVisible;

    public $supportingImages;
    public $relatedVideosIteration = 1;
    public $relatedLinksIteration = 1;
    public $relatedDownloadsIteration = 1;
    public $relatedImagesIteration = 1;
    public $relatedVideos = [];
    public $relatedLinks = [];
    public $relatedDownloads = [];
    public $relatedImages = [];

    public $tagsKeywords, $tagsSubjects, $tagsYearGroups, $tagsTerms, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsFlags, $tagsNeet;
    public $eventKeywordTags = [];
    public $eventSubjectTags = [];
    public $eventTermsTags = [];
    public $eventYearGroupsTags = [];
    public $eventLscsTags = [];
    public $eventRoutesTags = [];
    public $eventSectorsTags = [];
    public $eventFlagTags = [];
    public $eventNeetTags = [];
    public $allYears, $allTerms;

    public $all_clients = NULL;
    public $all_institutions = NULL;
    public $clientsList = []; // list of all system clients
    public $client; //client selected
    public $institutionsList = []; //list of system institutions
    public $institutions = []; //list of selected institutions
    public $displayAllClients, $displayAllInstitutions, $displayClients, $displayInstitutions = 0;

    protected $rules = [
        'title' => 'required',
        'banner' => 'required|file_exists',
        'event_date' => 'required',

        'summary_image_type' => 'required',
        'summary_heading'=> 'required',
        'summary_text' => 'required',
        'summary' => 'requiredIf:summary_image_type,Custom|file_exists',

        'supportingImages.*.url' => 'required',
        'relatedVideos.*.url' => 'required',
        'relatedLinks.*.title' => 'required',
        'relatedLinks.*.url' => 'required',
        'relatedDownloads.*.title' => 'required',
        'relatedDownloads.*.url' => 'required',
        'relatedImages.*.alt' => 'required',
        'relatedImages.*.url' => 'required|file_exists',


    ];

    protected $messages = [
        'title.unique' => 'The title has already been taken. Please modify your title',
        'slug.unique' => 'The slug has already been taken. Please modify your title',

        'banner.file_exists' =>  'The banner image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',

        'relatedVideos.*.url.required' => 'The URL is required',

        'relatedLinks.*.title.required' => 'The title is required',
        'relatedLinks.*.url.required' => 'The URL is required',

        'relatedDownloads.*.title.required' => 'The title is required',
        'relatedDownloads.*.url.required' => 'The URL is required',

        'relatedImages.*.alt.required' => 'The ALT Tag is required',
        'relatedImages.*.url.required' => 'The URL is required',
        'relatedImages.*.url.file_exists' => 'The image you selected does not exist anymore at this location. Please select another file or find the same file if it has been moved.',

        'summary.required_if' => "The summary image is required when your summary image type is set to 'Custom'",
        'summary.file_exists' => 'The summary image file you selected does not exist anymore. Please select another file or find the same file if it has been moved.',

     /*   'client.required_without' => "Please select a client1",
        'client.uuid' => "Please select a client2",*/
    ];


    public function mount()
    {

        //Detects if we 'create' or 'edit'
        if (in_array('create', Request::segments() ) )
        {
            $this->action = "add";
        }  elseif (in_array('edit', Request::segments() ) ){
            $this->action = "edit";
        } else {
            abort(404);
        }



        if ($this->action == 'add'){
            $event = new Event;
            $this->authorize('create', $event);
        } else {
            $event = Event::where('uuid', Request::segments()[2])->firstOrFail();
            $this->authorize('update', $event);
        }


        //preview images are saved a temp folder
        if (!empty(Auth::guard('admin')->user()->client))
        {
            $this->tempImagePath = Auth::guard('admin')->user()->client->subdomain;
        } else {
            $this->tempImagePath = "global";
        }
        $this->tempImagePath = $this->tempImagePath.'/preview_images/'.Str::random(32);
        Storage::disk('public')->makeDirectory($this->tempImagePath);


        $this->canMakeEventLive = Auth::guard('admin')->user()->hasAnyPermission('event-make-live');


        //Detects if we 'create' or 'edit'
        if ($this->action == 'add')
        {

            $this->title = "";
            $this->slug = "";
            $this->event_date = "";
            $this->start_time = "";
            $this->end_time = "";
            $this->venue_name = "";
            $this->town = "";
            $this->all_clients = "Y";
            $this->all_institutions = "Y";
            $this->contact_name = "";
            $this->contact_number = "";
            $this->contact_email = "";
            $this->booking_link = "";
            $this->lead_para = "";
            $this->description = "";
            $this->video = "";
            $this->map = "";
            $this->summary_heading = "";
            $this->summary_text = "";
            $this->summary_image_type = 'Automatic';
            $this->ref = ""; //Uuid

            $this->allYears = $this->allTerms = 1;

        } elseif ($this->action == 'edit') {

            $this->action = "edit";

            $this->ref = Request::segments()[2];
            $eventService = new EventService();
            $event = $eventService->getEventDetails( $this->ref );//Uuid

            if (!$event){abort(404);}

            $this->title = $event->title;
            $this->slug = $event->slug;
            $this->event_date = Carbon::createFromFormat('Y-m-d', $event->date)->format('d/m/Y');
            $this->start_time_hour = $event->start_time_hour;
            $this->start_time_min = $event->start_time_min;
            $this->end_time_hour = $event->end_time_hour;
            $this->end_time_min = $event->end_time_min;
            $this->venue_name = $event->venue_name;
            $this->town = $event->town;
            $this->all_clients = ($event->all_clients == "N") ? NULL : 'Y';
            $this->all_institutions = ($event->all_institutions == "N") ? NULL : 'Y';
            $this->contact_name = $event->contact_name;
            $this->contact_number = $event->contact_number;
            $this->contact_email = $event->contact_email;
            $this->booking_link = $event->booking_link;
            $this->online_link = $event->online_link;
            $this->lead_para = $event->lead_para;
            $this->description = $event->description;
            $this->video = $event->video;
            $this->map = $event->map;
            $this->summary_heading = $event->summary_heading;
            $this->summary_text = $event->summary_text;
            $this->summary_image_type = $event->summary_image_type;

            $banner = $event->getMedia('banner')->first();
            if ($banner)
            {
                $bannerUrl = parse_encode_url($banner->getUrl());
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal = $bannerUrl;//$banner->getCustomProperty('folder'); //$banner->getFullUrl();
                $this->banner_alt = $banner->getCustomProperty('alt');
                $this->bannerImagePreview = $bannerUrl; // retrieves URL of converted image
            }

            $summary = $event->getMedia('summary')->first();
            if ($summary)
            {
                $summaryUrl = parse_encode_url($summary->getUrl());
                $this->summary = $summary->getCustomProperty('folder'); //relative path in field
                $this->summaryOriginal = $summaryUrl;
                $this->summaryImageSlotLargePreview = $summary->getUrl('large'); // retrieves URL of converted image
                $this->summaryImageSlotSmallPreview = $summary->getUrl('small'); // retrieves URL of converted image
            }


        //if not 'edit' and not 'create'
        } else {
            abort(404);
        }




        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->get()->toArray();
        if ($this->action == 'add')
        {
            foreach($this->tagsYearGroups as $key => $value){
                $this->eventYearGroupsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $eventYearGroupsTags = $event->tagsWithType('year');
            foreach($eventYearGroupsTags as $key => $value){
                $this->eventYearGroupsTags[] = $value['name'];
            }

            if ( count($this->tagsYearGroups) == count($eventYearGroupsTags) )
            {
                $this->allYears = 1;
            }
        }


        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->where('live', 'Y')->get()->toArray();
        if ($this->action == 'add')
        {
            foreach($this->tagsLscs as $key => $value){
                //$this->eventLscsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $eventLscsTags = $event->tagsWithType('career_readiness');
            foreach($eventLscsTags as $key => $value){
                $this->eventLscsTags[] = $value['name'];
            }
        }

        $this->tagsTerms = SystemTag::select('uuid', 'name')->where('type', 'term')->where('live', 'Y')->get()->toArray();
        if ($this->action == 'add')
        {
            foreach($this->tagsTerms as $key => $value){
                $this->eventTermsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $eventTermsTags = $event->tagsWithType('term');
            foreach($eventTermsTags as $key => $value){
                $this->eventTermsTags[] = $value['name'];
            }

            if ( count($this->tagsTerms) == count($eventTermsTags) )
            {
                $this->allTerms = 1;
            }
        }

        $this->tagsRoutes = SystemTag::select('uuid', 'name')->where('type', 'route')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $eventRoutesTags = $event->tagsWithType('route');
        foreach($eventRoutesTags as $key => $value){
            $this->eventRoutesTags[] = $value['name'];
        }

        $this->tagsSectors = SystemTag::select('uuid', 'name')->where('type', 'sector')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $eventSectorsTags = $event->tagsWithType('sector');
        foreach($eventSectorsTags as $key => $value){
            $this->eventSectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::select('uuid', 'name')->where('type', 'subject')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $eventSubjectTags = $event->tagsWithType('subject');
        foreach($eventSubjectTags as $key => $value){
            $this->eventSubjectTags[] = $value['name'];
        }

        $this->tagsFlags = SystemTag::select('uuid', 'name')->where('type', 'flag')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $eventFlagTags = $event->tagsWithType('flag');
        foreach($eventFlagTags as $key => $value){
            $this->eventFlagTags[] = $value['name'];
        }

        $this->tagsNeet = SystemTag::select('uuid', 'name')->where('type', 'neet')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $eventNeetTags = $event->tagsWithType('neet');
        foreach($eventNeetTags as $key => $value){
            $this->eventNeetTags[] = $value['name'];
        }

        $this->tagsKeywords = SystemTag::select('uuid', 'name')->where('type', 'keyword')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $eventKeywordTags = $event->tagsWithType('keyword');
        foreach($eventKeywordTags as $key => $value){
            $this->eventKeywordTags[] = $value['name'];
        }



        if ($this->summary_image_type == 'Automatic')
        {
            $this->summaryImageIsVisible = False;
        } else {
            $this->summaryImageIsVisible = True;
        }




        $this->relatedVideos = $event->relatedVideos->toArray();

        $this->relatedLinks = $event->relatedLinks->toArray();



        $relatedDownloads = $event->getMedia('supporting_downloads');
        if (count($relatedDownloads) > 0)
        {
            foreach($relatedDownloads as $key => $value)
            {
                $tmpPath = parse_url($value->getUrl());

                $this->relatedDownloads[] = [
                    'title' => $value->getCustomProperty('title'),
                    'url' => $value->getCustomProperty('folder'),
                    'open_link' => $tmpPath['path']
                ];
            }
        }


        $relatedImages = $event->getMedia('supporting_images');
        if (count($relatedImages) > 0)
        {
            foreach($relatedImages as $key => $value)
            {
                //gets the URL of the conversion
                $previewPath = parse_encode_url($value->getUrl()); //$value->getUrl('supporting_images')

                $this->relatedImages[] = [
                    'title' => $value->getCustomProperty('title'),
                    'alt' => $value->getCustomProperty('alt'),
                    'url' => $value->getCustomProperty('folder'),
                    'open_link' => $previewPath,
                    'preview' => $previewPath
                ];
            }
        }



        if (isGlobalAdmin()){

            $this->displayAllClients = 1;

            //we get the client from the DB using the uuid passed from the dropdown
            $clients = Client::select('id', 'uuid', 'name')->get();
            foreach($clients as $client)
            {
                if ($event->client_id == $client->id)
                {
                    $this->client = $client->uuid;
                }
                $this->clientsList[] = ['uuid' => $client->uuid, 'name' => $client->name ];
            }


            //if the event is not allocated to all clients/instituttions
            if ($this->all_clients == NULL)
            {

                $this->loadEventInstitutions($event); //loads the institutions allocated to the event
                $this->loadInstitutions();// loads all the clients institutions
                $this->displayClients = 1;
                $this->displayInstitutions = 1;
            }

        } elseif (isClientAdmin()){

            $this->displayAllClients = 0;
            $this->displayClients = 0;

            $this->displayAllInstitutions = 1;


            $client = Client::select('uuid')->where('id', Auth::guard('admin')->user()->client_id)->firstOrFail();

            //current client selection
            $this->client = $client->uuid;

            if ($this->all_institutions == NULL)
            {
                $this->loadEventInstitutions($event); //loads the institutions allocated to the event
                $this->loadInstitutions(); // loads all the clients institutions
                $this->displayInstitutions = 1;
            }

        } elseif (isClientAdvisor()){

            $this->displayAllClients = 0;
            $this->displayClients = 0;

            $this->displayAllInstitutions = 0;

             $client = Client::select('uuid')->where('id', Auth::guard('admin')->user()->client_id)->firstOrFail();

            //current client selection
            $this->client = $client->uuid;


            $this->loadEventInstitutions($event); //loads the institutions allocated to the event
            $this->loadAdvisorInstitutions(); // only loads the institutions allocated to the advisor
            $this->displayInstitutions = 1;


        }

        $this->activeTab = "event-details";

    }



    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }






    /**
     * AllTermsOn
     * when the "all terms" checkbox is selected
     *
     * @return void
     */
    public function AllTermsOn()
    {
        $this->tagsTerms = SystemTag::select('uuid', 'name')->where('type', 'term')->where('live', 'Y')->get()->toArray();

        $this->eventTermsTags = [];
        foreach($this->tagsTerms as $key => $value){
            $this->eventTermsTags[] = $value['name']['en'];
        }

    }


    /**
     * AllYearsOn
     * when the "all years" checkbox is selected
     *
     * @return void
     */
    public function AllYearsOn()
    {
        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->get()->toArray();

        $this->eventYearGroupsTags = [];
        foreach($this->tagsYearGroups as $key => $value){
            $this->eventYearGroupsTags[] = $value['name']['en'];
        }

    }

    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {

        if ($propertyName == "title"){
            $this->summary_heading = $this->title;

            $this->slug = Str::slug($this->title);

            $this->validateOnly('slug', [
                'title' => 'required',
//                'slug' => $this->slugRule()
            ]);

        }elseif ($propertyName == "lead_para"){

            $this->summary_text = $this->lead_para;

        } elseif ($propertyName == "allYears"){
            if ($this->allYears == 1){
                $this->AllYearsOn();
            }

        } elseif ($propertyName == "allTerms"){
            if ($this->allTerms == 1){
                $this->AllTermsOn();
            }

        } elseif ($propertyName == "summary_image_type"){

            if ($this->summary_image_type == 'Automatic')
            {
                if (!empty($this->banner))
                {
                    $this->makeSummaryImage($this->banner);
                }
            } else {
                if (!empty($this->summary))
                {
                    $this->makeSummaryImage($this->summary);
                }
            }

        } elseif ($propertyName == "all_clients"){
            if ($this->all_clients == 'Y')
            {
                $this->displayClients = 0;
                $this->displayInstitutions = 0;
                $this->client = "";
                $this->institutions = [];

            } else {
                $this->displayClients = 1;
            }

        } elseif ($propertyName == "all_institutions"){
            if ($this->all_institutions == 'Y')
            {
                $this->displayInstitutions = 0;
                $this->institutions = [];

            } else {
                $this->loadInstitutions();
                $this->displayInstitutions = 1;
            }

        } elseif ($propertyName == "client"){

            if ($this->client)
            {
                $this->loadInstitutions();
            } else {
                $this->displayInstitutions = 0;
            }

        } else {
            $this->validateOnly($propertyName);
        }

    }



    /**
     * Loads the institutions in the client filter
     * loadInstitutions
     *
     * @return void
     */
    public function loadInstitutions()
    {

        $clientUuid = $this->client;

        $this->displayInstitutions = 1;

        //loads all the client's instittutions
        $institutions = Institution::select('uuid', 'name')
                                ->whereRaw('(select `id` from `clients` where `clients`.`uuid` = "'.$clientUuid.'") = `institutions`.`client_id`')
                                ->orderBy('name')
                                ->get()
                                ->toArray();

        if ($institutions)
        {

            $this->institutionsList = [];
            foreach($institutions as $institution)
            {
                $this->institutionsList[] = ['uuid' => $institution['uuid'], 'name' => $institution['name'] ];
            }
        } else {
            $this->institutionsList = [];
        }

    }


    /**
     * loadEventInstitutions
     * loads the institutions attached to an event
     *
     * @param  mixed $event
     * @return void
     */
    public function loadEventInstitutions($event)
    {

        $clientInstitutions = $event->institutions()->get();
        if ($clientInstitutions)
        {
            foreach($clientInstitutions as $institution)
            {
                $this->institutions[] = $institution->uuid;
            }

        }

    }




    /**
     * loadAdvisorInstitutions
     * loads the institutions allocated to the advisor
     *
     * @return void
     */
    public function loadAdvisorInstitutions()
    {

        $institutions = Auth::guard('admin')->user()->getAdminInstitutions();
        $this->institutionsList = [];
        foreach($institutions as $institution)
        {
            $this->institutionsList[] = ['uuid' => $institution['uuid'], 'name' => $institution['name'] ];
        }

    }


    public function slugRule()
    {

        $clientId = getClientId();

        if ($this->action == 'create')
        {

            //The slug must be checked against global and client content
            return [ 'required',
                      //  'alpha_dash',
                        //select count(*) as aggregate from `pages` where `slug` = page-test
                        //and (`client_id` = 1 or `client_id` = NULL)))
                            Rule::unique('events')->where(function ($query)  use ($clientId) {
                                $query->where('client_id', $clientId);
                                $query->orwhere('client_id', NULL );
                            })
                        ];

        } else {

            //The slug must be checked against global and client content
            return [ 'required',
                       // 'alpha_dash',
                        //select count(*) as aggregate from `pages` where `slug` = page-test and
                        //(`uuid` != a0fd956a-11ed-4394-94c4-49760ec91907 and (`client_id` = 1 or `client_id` = NULL)))
                        Rule::unique('events')->where(function ($query)  use ($clientId) {
                            $query->where('uuid', '!=', $this->ref );
                            $query->where(function ($query) use ($clientId) {
                                $query->where('client_id', $clientId);
                                $query->orwhere('client_id', NULL );
                            });
                        })
                    ];
        }

    }



    public function store($param)
    {

        $this->rules['title'] = $this->slugRule();
        //
        //adds the client rules dynamically

        //$this->rules = array('client' => 'valid_client:N|uuid') + $this->rules;

        //$this->rules['client'] = 'valid_client:'.$this->all_clients.'|uuid';
//dd($this->rules);
        $this->validate($this->rules, $this->messages);

        $verb = ($this->action == 'add') ? 'Created' : 'Updated';

        DB::beginTransaction();

        try {

            $eventService = new EventService();

            //if the 'live' action needs to be processed
            if (strpos($param, 'live') !== false) {
                $eventService->storeAndMakeLive($this);
            } else {
                $newEvent = $eventService->store($this);

                //this line is required when creating a event
                //after saving the event, the eventUuid variable is set and the event can now be edited
                $this->ref = $newEvent->uuid;
                $this->action = 'edit';
            }


             DB::commit();

            Session::flash('success', 'Your event has been '.$verb.' Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Content could not be '.$verb.' Successfully');

        }

        //if the 'exit' action needs to be processed
        if (strpos($param, 'exit') !== false)
        {

            $this->removeTempImagefolder();

            return redirect()->route('admin.events.index');

        }

        return redirect()->route('admin.events.index');

    }


    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
    }

    /**
     * Add a video
     */
    public function addRelatedVideo()
    {
        $this->relatedVideos[] = ['url' => '', 'title' => ''];
    }

    /**
     * Add a link
     */
    public function addRelatedLink()
    {
        $this->relatedLinks[] = ['title' => '', 'url' => ''];
    }

    /**
     * Add a download
     */
    public function addRelatedDownload()
    {
        $this->relatedDownloads[] = ['title' => '', 'url' => '', 'open_link' => ''];
    }

    /**
     * Add an image
     */
    public function addRelatedImage()
    {
        $this->relatedImages[] = ['title' => '', 'alt' => '', 'url' => '', 'open_link' => '', 'preview' => ''];
    }

    /**
     * Remove a video
     */
    public function removeRelatedVideo($relatedVideosIteration)
    {
        unset($this->relatedVideos[$relatedVideosIteration]);
    }

    /**
     * Remove a link
     */
    public function removeRelatedLink($relatedLinksIteration)
    {
        unset($this->relatedLinks[$relatedLinksIteration]);
    }

    /**
     * Remove a download
     */
    public function removeRelatedDownload($relatedDownloadsIteration)
    {
        unset($this->relatedDownloads[$relatedDownloadsIteration]);
    }

    /**
     * Remove an image
     */
    public function removeRelatedImage($relatedImagesIteration)
    {
        unset($this->relatedImages[$relatedImagesIteration]);
    }


    /**
     * updateVideosOrder
     *
     * @param  mixed $videosOrder
     * @return void
     */
    public function updateVideosOrder($videosOrder)
    {

        $videosOrder = explode(",", $videosOrder);

        $tmpVideos = [];

        foreach($videosOrder as $key => $value)
        {
            $tmpVideos[] = $this->relatedVideos[$value];
        }

        $this->relatedVideos = $tmpVideos;

    }


    public function makeRelatedDownload($field, $url)
    {

        $relatedDownloadId = Str::between($field, 'file_relatedDownloads[', "]['url']");
        $this->relatedDownloads[$relatedDownloadId]['url'] = $url;
        $this->relatedDownloads[$relatedDownloadId]['open_link'] = $url;

    }



    public function makeRelatedImage($field, $url)
    {

        $version = date("YmdHis");

        //Returns information about a file path
        $fileDetails = pathinfo($url);

        //encodes the URL
        $encodedFilePath = parse_encode_url($url);

        //extracts the ID of image
        $relatedImageId = Str::between($field, 'file_relatedImages[', "]['url']");
        $this->relatedImages[$relatedImageId]['url'] = $url;
        $this->relatedImages[$relatedImageId]['open_link'] = $encodedFilePath;

        //generates preview filename
        $imageName = "preview_supp_image_".$relatedImageId.".".$fileDetails['extension'];

        //generates Image conversion
         Image::load (public_path( $url ) )
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

        //stores the preview filename in array
        $this->relatedImages[$relatedImageId]['preview'] = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

    }



    /**
     * bannerValidation
     * Custom validation on the banner
     *
     * @param  mixed $image
     * @return void
     */
    public function bannerValidation($image)
    {

        $this->resetErrorBag('banner');

        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );

        $dimensionsErrorMessage = __('ck_admin.events.banner.upload.error_messages.dimensions', ['width' => config('global.events.banner.upload.required_size.width'), 'height' => config('global.events.banner.upload.required_size.height') ]);

        //dimension validation
        if ( ($width != config('global.events.banner.upload.required_size.width')) || ($height < config('global.events.banner.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('banner', $dimensionsErrorMessage);
        }

        //if no error was found with the image dimensions, we check the image type
        if ($error == 0)
        {

            // 1	IMAGETYPE_GIF
            // 2	IMAGETYPE_JPEG
            // 3	IMAGETYPE_PNG
            // 18	IMAGETYPE_WEBP
            if (!in_array( exif_imagetype(public_path($image)) , [1, 2, 3, 18]) )
            {
                $error = 1;
                $this->addError('summary', __('ck_admin.events.summary.upload.error_messages.type') );
            }

        }

        return $error;
    }


    /**
     * summaryImageValidation
     * Custom validation on the banner
     *
     * @param  mixed $image
     * @return void
     */
    public function summaryImageValidation($image)
    {

        $this->resetErrorBag('summary');

        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );

        $dimensionsErrorMessage = __('ck_admin.events.summary.upload.error_messages.dimensions', ['width' => config('global.events.summary.upload.required_size.width'), 'height' => config('global.events.summary.upload.required_size.height') ]);

        //dimension validation
        if ( ($width != config('global.events.summary.upload.required_size.width')) || ($height < config('global.events.summary.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('summary', $dimensionsErrorMessage);
        }


        //if no error was found with the image dimensions, we check the image type
        if ($error == 0)
        {
            // 1	IMAGETYPE_GIF
            // 2	IMAGETYPE_JPEG
            // 3	IMAGETYPE_PNG
            // 18	IMAGETYPE_WEBP
            if (!in_array( exif_imagetype(public_path($image)) , [1, 2, 3, 18]) )
            {

                $error = 1;
                $this->addError('summary', __('ck_admin.articles.summary.upload.error_messages.type') );
            }

        }

        return $error;
    }

    public function makeBannerImage($image)
    {

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->bannerValidation($image) == FALSE)
        {

            $this->resetErrorBag('banner');

            $version = date("YmdHis");

            $this->banner = $image; //relative path in field

            //split the string, encode the parts and join the string together again.
            $this->bannerOriginal = implode('/', array_map('rawurlencode', explode('/', $image)));//relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->bannerImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

            //if automatic
            if ($this->summary_image_type == 'Automatic')
            {
                //generates the summary image
                $this->makeSummaryImage($image);
            }

        }

    }



    public function makeSummaryImage($image)
    {

        $error = 1;
        if ($this->summary_image_type == 'Custom')
        {

            if ($this->summaryImageValidation($image) == FALSE)
            {
                $error = 0;

                $this->summary = $image; //relative path in field
                $this->summaryOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image
            }

        } elseif ($this->summary_image_type == 'Automatic') {
            $error = 0;
        }



        if ($error == 0)
        {

            //clears error for summary images
            $this->resetErrorBag('summary');

            $version = date("YmdHis");

            //Returns information about a file path
            $fileDetails = pathinfo($image);

            //assigns the preview filename
            $imageNameSlotLarge = "preview_summary_large.".$fileDetails['extension'];
            $imageNameSlotSmall = "preview_summary_small.".$fileDetails['extension'];


            //generates image conversions
            Image::load (public_path( $image ) )
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSlotLarge ));

            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 528, 528)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageNameSlotSmall ));

            //assigns preview images
            $this->summaryImageSlotLargePreview = '/storage/'.$this->tempImagePath.'/'.$imageNameSlotLarge.'?'.$version;//versions the file to prevent caching
            $this->summaryImageSlotSmallPreview = '/storage/'.$this->tempImagePath.'/'.$imageNameSlotSmall.'?'.$version;//versions the file to prevent caching

        }
    }



    public function render()
    {
        return view('livewire.admin.event-form');
    }

}
