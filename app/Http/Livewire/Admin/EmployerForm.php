<?php

namespace App\Http\Livewire\Admin;

use App\Models\Content;
use Livewire\Component;
use Spatie\Image\Image;
use App\Models\employer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\EmployerService;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EmployerForm extends Component
{
    use AuthorizesRequests;

    protected $listeners = ['make_employer_logo_image' => 'makeEmployerLogoImage',
                            'article_selector' => 'articleSelector',
                        ];

    public $name, $slug, $website;
    public $action;
    public $ref;
    public $activeTab;

    public $logo;
    public $employerLogoOriginal;
    public $employerLogoPreview;
    public $employerLogo_alt;

    public $tempImagePath;

    public $employer_article = NULL;

    protected $rules = [
        'name' => 'required',
        'logo' => 'required',
        'employerLogo_alt' => 'required',
    ];

    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your name',
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
            $employer = new Employer;
            $this->authorize('create', $employer);
        } else {
            $employer = Employer::where('uuid', Request::segments()[2])->firstOrFail();
            $this->authorize('update', $employer);
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


        //Detects if we 'create' or 'edit'
        if ($this->action == 'add')
        {

            $this->name = "";
            $this->slug = "";
            $this->website = "";

            $this->ref = ""; //Uuid

        } elseif ($this->action == 'edit') {

            $this->action = "edit";

            $this->ref = Request::segments()[2];
            $employerService = new EmployerService();
            $employer = $employerService->getEmployerDetails( $this->ref );//Uuid

            if (!$employer){abort(404);}


            $this->name = $employer->name;
            $this->slug = $employer->slug;
            $this->website = $employer->website;

            if (!empty($employer->article_id))
            {
                $employerArticle = Content::select('uuid', 'title')->where('id', $employer->article_id)->firstOrFail();
                $this->employer_article = $employerArticle->uuid;
            }

            $employerLogo = $employer->getMedia('logo')->first();
            if ($employerLogo)
            {
                $employerLogoUrl = parse_encode_url($employerLogo->getUrl());
                $this->logo = $employerLogo->getCustomProperty('folder'); //relative path in field
                $this->employerLogoOriginal =  $employerLogoUrl; //$employerLogoUrl->getFullUrl();
                $this->employerLogo_alt = $employerLogo->getCustomProperty('alt');
                $this->employerLogoImagePreview = $employerLogoUrl; // retrieves URL of converted image
            }


        //if not 'edit' and not 'create'
        } else {
            abort(404);
        }


        $this->activeTab = "employer-details";

    }



    /**
     * Keeps track of the active Tab
     *
     */
    public function updateTab($tabName)
    {
        $this->activeTab = $tabName;
    }


    public function articleSelector($data)
    {
        if ($data[1] == NULL){
            $this->{$data[0]} = NULL;
        } else {
            $this->{$data[0]} = $data[1];
        }

    }


    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {

        if ($propertyName == "name"){
            $this->slug = Str::slug($this->name);

            $this->validateOnly('slug', [
                'name' => 'required',
            ]);

        }

    }




    public function store($param)
    {

        $this->validate($this->rules, $this->messages);

        $verb = ($this->action == 'add') ? 'Created' : 'Updated';

        DB::beginTransaction();

        try {

            $employerService = new EmployerService();

            $newEmployer = $employerService->store($this);

            DB::commit();

            Session::flash('success', 'Your employer has been '.$verb.' Successfully');

        } catch (\Exception $e) {

            DB::rollback();

            Session::flash('fail', 'Your employer could not be '.$verb.' Successfully');

        }

        //if the 'exit' action needs to be processed
        if (strpos($param, 'exit') !== false)
        {

            $this->removeTempImagefolder();

            return redirect()->route('admin.employers.index');

        }

        return redirect()->route('admin.employers.index');

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


    public function makeEmployerLogoImage($image)
    {
        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->employerLogoValidation($image) == FALSE)
        {

            $version = date("YmdHis");

            $this->logo = $image; //relative path in field
            $this->employerLogoOriginal = implode('/', array_map('rawurlencode', explode('/', $image))); //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_employer_logo.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                //->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));


            //assigns the preview filename
            $this->employerLogoImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }



    public function render()
    {
        return view('livewire.admin.employer-form');
    }
}
