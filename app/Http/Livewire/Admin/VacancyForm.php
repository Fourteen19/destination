<?php

namespace App\Http\Livewire\Admin;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\Vacancy;
use Livewire\Component;
use Spatie\Image\Image;
use App\Models\Employer;
use App\Models\SystemTag;
use App\Models\VacancyRole;
use Illuminate\Support\Str;
use App\Models\VacancyRegion;
use Illuminate\Validation\Rule;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Services\Admin\VacancyService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VacancyForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['make_vacancy_image' => 'makeVacancyImage',
                            'update_videos_order' => 'updateVideosOrder',
                           ];

    public $title, $slug, $display_until, $contact_name, $contact_number, $contact_email, $contact_link, $online_link;
    public $lead_para, $description, $entry_requirements, $vac_map, $role_type, $region, $employer, $posted_at;
    public $action;
    //public $ref;
    public $activeTab;
    public $action_requested;

    public $employersList = [];
    public $employer_name, $employerLogoUrl; //contains the employer logo based on the employer selected

    public $vacancyUuid;
    //public $all_clients;
    //public $clients;

    public $isEmployer = 0; //is the loggedin user an "employer"


    public $all_clients = NULL;
    public $clientsList = []; // list of all system clients
    public $clients = []; //clients selected
    public $displayClients = True;
    public $displayAllClients = False;

    public $vacancyImage;
    public $vacancyImageOriginal;
    public $vacancyImagePreview;
    public $vacancyImage_alt;

    public $canMakeVacancyLive;
    public $tempImagePath;

    public $roles, $regions;
    public $role_type_name, $region_name;

    public $relatedVideosIteration = 1;
    public $relatedVideos = [];

    public $tagsKeywords, $tagsSubjects, $tagsYearGroups, $tagsTerms, $tagsLscs, $tagsRoutes, $tagsSectors, $tagsFlags, $tagsNeet;
    public $vacancyKeywordTags = [];
    public $vacancySubjectTags = [];
    public $vacancyTermsTags = [];
    public $vacancyYearGroupsTags = [];
    public $vacancyLscsTags = [];
    public $vacancyRoutesTags = [];
    public $vacancySectorsTags = [];
    public $vacancyFlagTags = [];
    public $vacancyNeetTags = [];
    public $allYears, $allTerms;


    protected $rules = [
        'title' => 'required',
        'slug' => 'slug.unique',
        'display_until' => '',
        'role_type' => 'required|uuid',
        'region' => 'required|uuid',
        'employer' => 'required|uuid',
        'vacancyImage' => 'required',
        'vacancyImage_alt' => 'required',
        'relatedVideos.*.url' => 'required',
    ];

    protected $messages = [
        'slug.unique' => 'The title has already been taken. Please modify your title',
        'role_type.required' => 'Please select a role type',
        'role_type.uuid' => 'The role type you selected is invalid',
        'region.required' => 'Please select an area',
        'region.uuid' => 'The area you selected is invalid',
        'employer.required' => 'Please select an employer',
        'employer.uuid' => 'Please select an employer',
        'vacancyImage.required' => 'Please select an image',
        'vacancyImage_alt.required' => 'Please enter an Alt Tag for your image',
        'relatedVideos.*.url.required' => 'The URL is required',
    ];


    public function mount()
    {
        if (isemployer(Auth::guard('admin')->user()))
        {
            $this->isEmployer = 1;
        }


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
            $vacancy = new Vacancy;
            $this->authorize('create', $vacancy);
        } else {
            $this->vacancyUuid = Request::segments()[2];
            $vacancy = Vacancy::where('uuid', $this->vacancyUuid)->firstOrFail();
            $this->authorize('update', $vacancy);
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


        $this->canMakeVacancyLive = Auth::guard('admin')->user()->hasAnyPermission('vacancy-make-live');


        //Detects if we 'create' or 'edit'
        if ($this->action == 'add')
        {

            $this->title = "";
            $this->slug = "";
            $this->display_until = "";
            $this->contact_name = "";
            $this->contact_number = "";
            $this->contact_email = "";
            $this->contact_link = "";
            $this->online_link = "";
            $this->lead_para = "";
            $this->description = "";
            $this->entry_requirements = "";
            $this->vac_map = "";
            $this->role_type = "";
            $this->region = "";

            $this->role_type_name = "";
            $this->region_name = "";

            $this->employer_name = "";

            //if the admin is an employer
            if ($this->isEmployer == 1)
            {
                //set per default the employer
                $this->employer = Auth::guard('admin')->user()->employer->uuid;

            }

            //if global admin
            if (isGlobalAdmin())
            {
                $this->all_clients = TRUE; //Tick the "all clients" option
            } else {
                $this->all_clients = FALSE;//else set the
            }
               $this->clients = [];

            $this->posted_at = date('l jS \of F Y');

            $this->vacancyUuid = ""; //Uuid

            //"all years" ans "all terms" to be selected
            $this->allYears = $this->allTerms = 1;

        } elseif ($this->action == 'edit') {

            $this->action = "edit";

            //$this->ref = $this->vacancy_uuid;
            $vacancyService = new VacancyService();
            $vacancy = $vacancyService->getVacancyDetails( $this->vacancyUuid );//Uuid

            if (!$vacancy){abort(404);}

            $this->title = $vacancy->title;
            $this->slug = $vacancy->slug;
            $this->display_until = Carbon::createFromFormat('Y-m-d', $vacancy->display_until)->format('d/m/Y');
            $this->contact_name = $vacancy->contact_name;
            $this->contact_number = $vacancy->contact_number;
            $this->contact_email = $vacancy->contact_email;
            $this->contact_link = $vacancy->contact_link;
            $this->online_link = $vacancy->online_link;
            $this->lead_para = $vacancy->lead_para;
            $this->description = $vacancy->description;
            $this->entry_requirements = $vacancy->entry_requirements;
            $this->vac_map = $vacancy->map;

            $this->employerLogoUrl = "";

            $this->employer_name = $vacancy->employer_name;

            if (isset($vacancy->role->uuid))
            {
                $this->role_type = $vacancy->role->uuid;
            }

            if (isset($vacancy->region->uuid))
            {
                $this->region = $vacancy->region->uuid;
                $this->region_name = $vacancy->region->name;
            }

            //if the user logged in an "Employer"
            if ($this->isEmployer == 1)
            {

                $this->employer = Auth::guard('admin')->user()->employer->uuid;

                if (isset($vacancy->employer->name))
                {
                    $this->role_type_name = $vacancy->employer->name;
                }

            } else {

                if (isset($vacancy->employer->uuid))
                {
                    $this->employer = $vacancy->employer->uuid;
                    $this->role_type_name = $vacancy->employer->name;
                }
            }

            //if global admin
            if (isGlobalAdmin())
            {
                $this->all_clients = ($vacancy->all_clients == "N") ? NULL : True; //check if we need to tick the "all clients" option
            } else {
                $this->all_clients = FALSE; //all clients is set to FALSE
            }

            $this->clients = [];


            $this->posted_at = $vacancy->created_at;



            $vacancyImage = $vacancy->getMedia('vacancy_image')->first();
            if ($vacancyImage)
            {
                $vacancyImageUrl = parse_encode_url($vacancyImage->getUrl());
                $this->vacancyImage = $vacancyImage->getCustomProperty('folder'); //relative path in field
                $this->vacancyImageOriginal =  $vacancyImageUrl; //$vacancyImageUrl->getFullUrl();
                $this->vacancyImage_alt = $vacancyImage->getCustomProperty('alt');
                $this->vacancyImagePreview = $vacancyImageUrl; // retrieves URL of converted image
            }

        //if not 'edit' and not 'create'
        } else {
            abort(404);
        }



        $this->relatedVideos = $vacancy->relatedVideos->toArray();

        $this->roles = VacancyRole::where('display', 'Y')->orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();
        $this->regions = VacancyRegion::where('display', 'Y')->orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();
        $this->employersList = Employer::orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();

        $clientsList = Client::select('name', 'uuid')->orderBy('name', 'ASC');
        foreach($clientsList as $client)
        {
            $this->clientsList[] = ['uuid' => $client['uuid'], 'name' => $client['name'] ];
        }



        $this->tagsYearGroups = SystemTag::select('uuid', 'name')->where('type', 'year')->get()->toArray();
        if ($this->action == 'add')
        {
            foreach($this->tagsYearGroups as $key => $value){
                $this->vacancyYearGroupsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $vacancyYearGroupsTags = $vacancy->tagsWithType('year');
            foreach($vacancyYearGroupsTags as $key => $value){
                $this->vacancyYearGroupsTags[] = $value['name'];
            }

            if ( count($this->tagsYearGroups) == count($vacancyYearGroupsTags) )
            {
                $this->allYears = 1;
            }
        }


        $this->tagsLscs = SystemTag::select('uuid', 'name')->where('type', 'career_readiness')->where('live', 'Y')->get()->toArray();
        if ($this->action == 'add')
        {
            foreach($this->tagsLscs as $key => $value){
                //$this->vacancyLscsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $vacancyLscsTags = $vacancy->tagsWithType('career_readiness');
            foreach($vacancyLscsTags as $key => $value){
                $this->vacancyLscsTags[] = $value['name'];
            }
        }

        $this->tagsTerms = SystemTag::select('uuid', 'name')->where('type', 'term')->where('live', 'Y')->get()->toArray();
        if ($this->action == 'add')
        {
            foreach($this->tagsTerms as $key => $value){
                $this->vacancyTermsTags[] = $value['name'][ app()->getLocale() ];
            }
        } else {
            $vacancyTermsTags = $vacancy->tagsWithType('term');
            foreach($vacancyTermsTags as $key => $value){
                $this->vacancyTermsTags[] = $value['name'];
            }

            if ( count($this->tagsTerms) == count($vacancyTermsTags) )
            {
                $this->allTerms = 1;
            }
        }

        $this->tagsRoutes = SystemTag::select('uuid', 'name')->where('type', 'route')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $vacancyRoutesTags = $vacancy->tagsWithType('route');
        foreach($vacancyRoutesTags as $key => $value){
            $this->vacancyRoutesTags[] = $value['name'];
        }

        $this->tagsSectors = SystemTag::select('uuid', 'name')->where('type', 'sector')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $vacancySectorsTags = $vacancy->tagsWithType('sector');
        foreach($vacancySectorsTags as $key => $value){
            $this->vacancySectorsTags[] = $value['name'];
        }

        $this->tagsSubjects = SystemTag::select('uuid', 'name')->where('type', 'subject')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $vacancySubjectTags = $vacancy->tagsWithType('subject');
        foreach($vacancySubjectTags as $key => $value){
            $this->vacancySubjectTags[] = $value['name'];
        }

        $this->tagsFlags = SystemTag::select('uuid', 'name')->where('type', 'flag')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $vacancyFlagTags = $vacancy->tagsWithType('flag');
        foreach($vacancyFlagTags as $key => $value){
            $this->vacancyFlagTags[] = $value['name'];
        }

        $this->tagsNeet = SystemTag::select('uuid', 'name')->where('type', 'neet')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $vacancyNeetTags = $vacancy->tagsWithType('neet');
        foreach($vacancyNeetTags as $key => $value){
            $this->vacancyNeetTags[] = $value['name'];
        }

        $this->tagsKeywords = SystemTag::select('uuid', 'name')->where('type', 'keyword')->where('live', 'Y')->orderBy('name', 'ASC')->get()->toArray();
        $vacancyKeywordTags = $vacancy->tagsWithType('keyword');
        foreach($vacancyKeywordTags as $key => $value){
            $this->vacancyKeywordTags[] = $value['name'];
        }




        if (isGlobalAdmin())
        {

            $this->displayAllClients = 1;
            $this->displayClients = 0;

            //we get the client from the DB using the uuid passed from the dropdown
            $clients = Client::select('id', 'uuid', 'name')->get();
            foreach($clients as $client)
            {
                $this->clientsList[] = ['uuid' => $client->uuid, 'name' => $client->name ];
            }


            if ($this->all_clients == NULL)
            {
                $this->loadVacancyClients($vacancy); //loads the institutions allocated to the event
                $this->displayClients = 1;
            }

        }



        if ($this->isEmployer == 1)
        {
            $this->activeTab = "vacancy-details";
        } else {
            $this->activeTab = "vacancy-employer-details";
        }



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
     * Add a video
     */
    public function addRelatedVideo()
    {
        $this->relatedVideos[] = ['url' => '', 'title' => ''];
    }

    /**
     * Remove a video
     */
    public function removeRelatedVideo($relatedVideosIteration)
    {
        unset($this->relatedVideos[$relatedVideosIteration]);
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



    /**
     * loadVacancyClients
     * loads the clients attached to the vacancy
     *
     * @param  mixed $event
     * @return void
     */
    public function loadVacancyClients($vacancy)
    {

        $clients = $vacancy->clients()->get();
        if ($clients)
        {
            foreach($clients as $client)
            {
                $this->clients[] = $client->uuid;
            }

        }

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

        $this->vacancyTermsTags = [];
        foreach($this->tagsTerms as $key => $value){
            $this->vacancyTermsTags[] = $value['name']['en'];
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

        $this->vacancyYearGroupsTags = [];
        foreach($this->tagsYearGroups as $key => $value){
            $this->vacancyYearGroupsTags[] = $value['name']['en'];
        }

    }



    /**
     * getEmployerData
     *
     * @return void
     */
    public function getEmployerData()
    {

        if (Uuid::isValid( $this->employer ))
        {

            $employerColection = Employer::select('id', 'name')->where('uuid', $this->employer)->get();

            if (count($employerColection) > 0)
            {
                $employer = $employerColection->first();

                $this->employerLogoUrl = $employer->getFirstMediaUrl('logo');

            } else {

                $this->employerLogoUrl = "";

            }

        } else {

            $this->employerLogoUrl = "";

        }
    }


    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {

        if ($propertyName == "title"){
            $this->slug = Str::slug($this->title);

            $this->validateOnly('slug', [
                'title' => 'required',
//                'slug' => $this->slugRule()
            ]);

        } elseif ($propertyName == "allYears"){
            if ($this->allYears == 1){
                $this->AllYearsOn();
            }

        } elseif ($propertyName == "allTerms"){
            if ($this->allTerms == 1){
                $this->AllTermsOn();
            }

        } elseif ($propertyName == "employer"){

            $this->getEmployerData();

        } elseif ($propertyName == "region"){

            $region = VacancyRegion::select('name')->where('uuid', $this->region)->first();

            if ($region)
            {
                $this->region_name = $region->name;
            } else {
                $this->region_name = "";
            }

        } elseif ($propertyName == "role_type"){

            $role = VacancyRole::select('name')->where('uuid', $this->role_type)->first();
            if ($role)
            {
                $this->role_type_name = $role->name;
            } else {
                $this->role_type_name = "";
            }

        } elseif ($propertyName == "all_clients"){
            if ($this->all_clients == 'Y')
            {
                $this->displayClients = 0;
                $this->clients = [];

            } else {
                $this->displayClients = 1;
            }

        }

    }


    public function slugRule()
    {

        $clientId = session()->get('adminClientSelectorSelected');

        if ($this->action == 'create')
        {

            //The slug must be checked against global and client content
            return [ 'required',
                        'alpha_dash',
                        /* //select count(*) as aggregate from `pages` where `slug` = page-test
                        //and (`client_id` = 1 or `client_id` = NULL)))
                            Rule::unique('vacancies')->where(function ($query) use ($clientId) {
                                $query->where('client_id', $clientId);
                                $query->orwhere('client_id', 'NULL' );
                            }) */

                            Rule::unique('vacancies')->where('deleted_at', NULL)

                        ];

        } else {

            //The slug must be checked against global and client content
            return [ 'required',
                        'alpha_dash',
                        //select count(*) as aggregate from `pages` where `slug` = page-test and
                        //(`uuid` != a0fd956a-11ed-4394-94c4-49760ec91907 and (`client_id` = 1 or `client_id` = NULL)))
                        Rule::unique('vacancies')->where(function ($query)  use ($clientId) {
                            $query->where('uuid', '!=', $this->vacancyUuid );
                            $query->where('deleted_at', NULL);
                        })
                    ];
        }

    }



    public function store($param)
    {

        $this->rules['slug'] = $this->slugRule();

        $this->validate($this->rules, $this->messages);

        $verb = ($this->action == 'add') ? 'Created' : 'Updated';

        DB::beginTransaction();

        try {

      $vacancyService = new VacancyService();

            //if the 'live' action needs to be processed
            if (strpos($param, 'live') !== false) {
                $vacancyService->storeAndMakeLive($this);
            } else {

                $newVacancy = $vacancyService->store($this);

                //this line is required when creating a vacancy
                //after saving the vacancy, the vacancyUuid variable is set and the vacancy can now be edited
                $this->vacancyUuid = $newVacancy->uuid;
                $this->action = 'edit';
            }

            DB::commit();

            Session::flash('success', 'Your vacancy has been '.$verb.' Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Content could not be '.$verb.' Successfully');

        }

        //if the 'exit' action needs to be processed
        if (strpos($param, 'exit') !== false)
        {

            $this->removeTempImagefolder();

            return redirect()->route('admin.vacancies.index');

        }

    }


    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
    }




    /**
     * vacancyImageValidation
     * Custom validation on the employer Logo
     *
     * @param  mixed $image
     * @return void
     */
    public function vacancyImageValidation($image)
    {

        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );


        $image_path = image_path_fix($image);
        $filesize = File::size( public_path($image_path) );

        $dimensionsErrorMessage = __('ck_admin.vacancies.image.upload.error_messages.dimensions', ['width' => config('global.vacancies.image.upload.required_size.width'), 'height' => config('global.vacancies.image.upload.required_size.height') ]);
        $filesizeErrorMessage = __('ck_admin.vacancies.image.upload.error_messages.filesize', ['max_filesize' => config('global.vacancies.image.upload.max_filesize') ]);

        //dimension validation
        if ( ($width < config('global.vacancies.image.upload.required_size.width')) || ($height < config('global.vacancies.image.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('vacancy_image', $dimensionsErrorMessage);
        }

        //image file size in KB
        if ( $filesize > config('global.vacancies.image.upload.max_filesize') * 1024 )
        {

            $error = 1;
            $this->addError('vacancy_image', $filesizeErrorMessage);
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
                $this->addError('summary', __('ck_admin.vacancies.image.upload.error_messages.type') );
            }

        }

        return $error;
    }

    public function makeVacancyImage($image)
    {
        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->vacancyImageValidation($image) == FALSE)
        {

            $version = date("YmdHis");

            $this->vacancyImage = $image; //relative path in field
            $this->vacancyImageOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_vacancy_image.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->width(1000)
                ->crop(Manipulations::CROP_CENTER, 1000, 800)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));


            //assigns the preview filename
            $this->vacancyImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }

    public function render()
    {
        //dd($this->getErrorBag());
        return view('livewire.admin.vacancy-form');
    }
}
