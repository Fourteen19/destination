<?php

namespace App\Http\Livewire\Admin;

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
use App\Services\Admin\VacancyService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VacancyForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['make_vacancy_image' => 'makeVacancyImage',];

    public $title, $slug, $contact_name, $contact_number, $contact_email, $contact_link, $online_link;
    public $lead_para, $description, $vac_vid, $vac_map, $role_type, $region, $employer, $posted_at;
    public $action;
    public $ref;
    public $activeTab;

    public $employersList = [];
    public $employer_name, $employerLogoUrl;

    //public $all_clients;
    //public $clients;
    ///
    public $all_clients = NULL;
    public $clientsList = []; // list of all system clients
    public $client; //client selected
    public $displayClients = True;
    public $displayAllClients = False;

    public $vacancyImage;
    public $vacancyImageOriginal;
    public $vacancyImagePreview;

    public $canMakeVacancyLive;
    public $tempImagePath;

    public $roles, $regions;
    public $role_type_name, $region_name;

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
        'role_type' => 'required|uuid',
        'region' => 'required|uuid',
    ];

    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your title',
        'role_type.required' => 'Please select a role type',
        'role_type.uuid' => 'The role type you selected is invalid',
        'region.required' => 'Please select a region',
        'region.uuid' => 'The region you selected is invalid',
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
            $vacancy = new Vacancy;
            $this->authorize('create', $vacancy);
        } else {
            $vacancy = Vacancy::where('uuid', Request::segments()[2])->firstOrFail();
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
            $this->contact_name = "";
            $this->contact_number = "";
            $this->contact_email = "";
            $this->contact_link = "";
            $this->online_link = "";
            $this->lead_para = "";
            $this->description = "";
            $this->vac_vid = "";
            $this->vac_map = "";
            $this->role_type = "";
            $this->region = "";

            $this->role_type_name = "";
            $this->region_name = "";

            $this->employer_name = "";

            $this->all_clients = True;
            $this->client = NULL;

            $this->posted_at = date('l jS \of F Y');

            $this->ref = ""; //Uuid

        } elseif ($this->action == 'edit') {

            $this->action = "edit";

            $this->ref = Request::segments()[2];
            $vacancyService = new VacancyService();
            $vacancy = $vacancyService->getVacancyDetails( $this->ref );//Uuid

            if (!$vacancy){abort(404);}

            $this->title = $vacancy->title;
            $this->slug = $vacancy->slug;
            $this->contact_name = $vacancy->contact_name;
            $this->contact_number = $vacancy->contact_number;
            $this->contact_email = $vacancy->contact_email;
            $this->contact_link = $vacancy->contact_link;
            $this->online_link = $vacancy->online_link;
            $this->lead_para = $vacancy->lead_para;
            $this->description = $vacancy->description;
            $this->vac_vid = $vacancy->video;
            $this->vac_map = $vacancy->map;

            $this->employer_name = "123";//$vacancy->employer_name;

            if (isset($vacancy->role->uuid))
            {
                $this->role_type = $vacancy->role->uuid;
            }

            if (isset($vacancy->region->uuid))
            {
                $this->region = $vacancy->region->uuid;
                $this->region_name = $vacancy->region->name;
            }
            if (isset($vacancy->employer->uuid))
            {
                $this->employer = $vacancy->employer->uuid;
                $this->role_type_name = $vacancy->employer->name;
            }

            $this->all_clients = $vacancy->all_clients;
            $this->client = $vacancy->client_id;

            $this->posted_at = $vacancy->created_at;
/*
            $employerLogo = $vacancy->getMedia('employer_logo')->first();
            if ($employerLogo)
            {
                $employerLogoUrl = parse_encode_url($employerLogo->getUrl());
                $this->employerLogo = $employerLogo->getCustomProperty('folder'); //relative path in field
                $this->employerLogoOriginal =  $employerLogoUrl; //$employerLogoUrl->getFullUrl();
                $this->employerLogoImagePreview = $employerLogoUrl; // retrieves URL of converted image
            }
 */

            $vacancyImage = $vacancy->getMedia('vacancy_image')->first();
            if ($vacancyImage)
            {
                $vacancyImageUrl = parse_encode_url($vacancyImage->getUrl());
                $this->vacancyImage = $vacancyImage->getCustomProperty('folder'); //relative path in field
                $this->vacancyImageOriginal =  $vacancyImageUrl; //$vacancyImageUrl->getFullUrl();
                $this->vacancyImagePreview = $vacancyImageUrl; // retrieves URL of converted image
            }

        //if not 'edit' and not 'create'
        } else {
            abort(404);
        }


        $this->roles = VacancyRole::where('display', 'Y')->orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();
        $this->regions = VacancyRegion::where('display', 'Y')->orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();
        $this->employersList = Employer::orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();
        $this->clientsList = Client::orderBy('name', 'ASC')->pluck('name', 'uuid')->toArray();




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




        if (isGlobalAdmin()){

            $this->displayAllClients = 1;
            $this->displayClients = 0;

            //we get the client from the DB using the uuid passed from the dropdown
            $clients = Client::select('id', 'uuid', 'name')->get();
            foreach($clients as $client)
            {
                /* if ($event->client_id == $client->id)
                {
                    $this->client = $client->uuid;
                } */
                $this->clientsList[] = ['uuid' => $client->uuid, 'name' => $client->name ];
            }


            if ($this->all_clients == NULL)
            {

                $this->loadVacancyClients($vacancy); //loads the institutions allocated to the event
                $this->displayClients = 1;
            }
        }



        $this->activeTab = "vacancy-employer-details";

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
     * loadVacancyClients
     * loads the clients attached to the vacancy
     *
     * @param  mixed $event
     * @return void
     */
    public function loadVacancyClients($event)
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

            $employer = Employer::select('id', 'name')->where('uuid', $this->employer)->first();

            $this->employer_name = $employer->name;

            $employerLogo = $employer->getMedia('logo')->first();

            if ($employerLogo)
            {
                $this->employerLogoUrl = parse_encode_url($employerLogo->getUrl());
            }

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
        }

    }

/*
    public function storeAndMakeLive()
    {

        //$this->slugRule();

        $this->validate($this->rules, $this->messages);

        $vacancyService = new VacancyService();
        $vacancyService->storeAndMakeLive($this);

        $this->removeTempImagefolder();

        return redirect()->route('admin.pages.index');

    } */



    public function slugRule()
    {

        $clientId = getClientId();

        if ($this->action == 'create')
        {

            //The slug must be checked against global and client content
            return [ 'required',
                        'alpha_dash',
                        //select count(*) as aggregate from `pages` where `slug` = page-test
                        //and (`client_id` = 1 or `client_id` = NULL)))
                            Rule::unique('vacancies')->where(function ($query)  use ($clientId) {
                                $query->where('client_id', $clientId);
                                $query->orwhere('client_id', 'NULL' );
                            })
                        ];

        } else {

            //The slug must be checked against global and client content
            return [ 'required',
                        'alpha_dash',
                        //select count(*) as aggregate from `pages` where `slug` = page-test and
                        //(`uuid` != a0fd956a-11ed-4394-94c4-49760ec91907 and (`client_id` = 1 or `client_id` = NULL)))
                        Rule::unique('vacancies')->where(function ($query)  use ($clientId) {
                            $query->where('uuid', '!=', $this->ref );
                            $query->where(function ($query) use ($clientId) {
                                $query->where('client_id', $clientId);
                                $query->orwhere('client_id', 'NULL' );
                            });
                        })
                    ];
        }

    }



    public function store($param)
    {

        //$this->rules['slug'] = $this->slugRule();

        $this->validate($this->rules, $this->messages);

        $verb = ($this->action == 'add') ? 'Created' : 'Updated';

        /* DB::beginTransaction();

        try { */

            $vacancyService = new VacancyService();

            //if the 'live' action needs to be processed
            if (strpos($param, 'live') !== false) {
                $vacancyService->storeAndMakeLive($this);
            } else {
                $newVacancy = $vacancyService->store($this);

                //this line is required when creating a vacancy
                //after saving the vacancy, the vacancyUuid variable is set and the vacancy can now be edited
                $this->vacancytUuid = $newVacancy->uuid;
                $this->action = 'edit';
            }


            /* DB::commit();

            Session::flash('success', 'Your vacancy has been '.$verb.' Successfully');
 */
        /* } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Content could not be '.$verb.' Successfully');

        } */

        //if the 'exit' action needs to be processed
        if (strpos($param, 'exit') !== false)
        {

            $this->removeTempImagefolder();

            return redirect()->route('admin.vacancies.index');

        }

        return redirect()->route('admin.vacancies.index');

    }


    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
    }







    /**
     * employerLogoValidation
     * Custom validation on the employer Logo
     *
     * @param  mixed $image
     * @return void
     */
    public function employerLogoValidation($image)
    {
        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );

        /* $dimensionsErrorMessage = __('ck_admin.vacancies.image.upload.error_messages.dimensions', ['width' => config('global.vacancies.image.upload.required_size.width'), 'height' => config('global.vacancies.image.upload.required_size.height') ]);

        //dimension validation
        if ( ($width != config('global.vacancies.image.upload.required_size.width')) || ($height != config('global.vacancies.image.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('vacancy_image', $dimensionsErrorMessage);
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

        } */

        return $error;
    }

/*
    public function makeEmployerLogoImage($image)
    {
        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->employerLogoValidation($image) == FALSE)
        {

            $version = date("YmdHis");

            $this->employerLogo = $image; //relative path in field
            $this->employerLogoOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_employer_logo.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));


            //assigns the preview filename
            $this->employerLogoImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }
 */




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

        $dimensionsErrorMessage = __('ck_admin.vacancies.image.upload.error_messages.dimensions', ['width' => config('global.vacancies.image.upload.required_size.width'), 'height' => config('global.vacancies.image.upload.required_size.height') ]);

        //dimension validation
        if ( ($width != config('global.vacancies.image.upload.required_size.width')) || ($height != config('global.vacancies.image.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('vacancy_image', $dimensionsErrorMessage);
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
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));


            //assigns the preview filename
            $this->vacancyImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }

    public function render()
    {
        return view('livewire.admin.vacancy-form');
    }
}
