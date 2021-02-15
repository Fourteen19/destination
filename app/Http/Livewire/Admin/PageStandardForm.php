<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Image\Image;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Image\Manipulations;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\Admin\PageStandardService;

class PageStandardForm extends Component
{

    protected $listeners = ['make_banner_image' => 'makeBannerImage'];

    public $title, $slug, $type, $lead, $body, $displayInHeader;
    public $action;
    public $pageRef;
    public $baseUrl;

    public $banner;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $tempImagePath;

    protected $rules = [
        'title' => 'required',
        'displayInHeader' => 'nullable'
    ];

    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your title',
    ];

    public function mount()
    {

        $this->baseUrl = config('app.url').'/';

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
        if (in_array('create', Request::segments() ) )
        {
            $this->action = "create";

            $this->title = "";
            $this->slug = "";
            $this->lead = "";
            $this->body = "";
            $this->pageRef = ""; //Uuid
            $this->displayInHeader = False;

        } elseif (in_array('edit', Request::segments() ) ){

            $this->action = "edit";

            $this->pageRef = Request::segments()[3];
            $pageService = new PageService();
            $page = $pageService->getPageDetails( $this->pageRef );//Uuid

            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->lead = $page->pageable->lead;
            $this->body = $page->pageable->body;
            $this->displayInHeader = (empty($page->displayInHeader)) ? 'N' : 'Y';

            $banner = $page->getMedia('banner')->first();
            if ($banner)
            {
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal =  $banner->getCustomProperty('folder'); //$banner->getFullUrl();
                $this->bannerImagePreview = $banner->getUrl('banner'); // retrieves URL of converted image
            }

        //if not 'edit' and not 'create'
        } else {
            abort(404);
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
                'slug' => [ 'required',
                            'alpha_dash',
                            //search the `contents` table for the slug name, ignores our current content
                            Rule::unique('pages')->where('client_id', '=', 1)->whereNot('uuid', $this->pageRef),
                        ]
                    ]);

        }

    }


    public function storeAndMakeLive()
    {

        if ($this->action == 'create')
        {

//           $this->authorize('create', 'App\Models\Content');

        } else {


        }

        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                'alpha_dash',
                                //search the `contents` table for the slug name, ignores our current content
                                Rule::unique('pages')->where('client_id', '=', 1)->whereNot('uuid', $this->pageRef),
                                ];

        $this->validate($this->rules, $this->messages);

        $pageService = new PageStandardService();
        $pageService->storeAndMakeLive($this);

        $this->removeTempImagefolder();

       return redirect()->route('admin.pages.index');

    }





    public function store()
    {

        if ($this->action == 'create')
        {
//           $this->authorize('create', 'App\Models\Content');
        } else {
//            $this->authorize('update', $this->content);
        }


        //The slug must be checked against global and client content
        $this->rules['slug'] = [ 'required',
                                'alpha_dash',
                                //search the `contents` table for the slug name, ignores our current content
                                Rule::unique('pages')->where('client_id', '=', 1)->whereNot('uuid', $this->pageRef),
                                ];

        $this->validate($this->rules, $this->messages);

        try {

            $pageStandardService = new PageStandardService();
            $pageStandardService->store($this);

            if ($this->action == 'create')
            {
                $message = "Your Page has been created Successfully";
            } else {
                $message = "Your Page has been edited Successfully";
            }

            Session::flash('success', $message);

        } catch (\Exception $e) {

            if ($this->action == 'create')
            {
                $message = "Your Page could not be created";
            } else {
                $message = "Your Page could not be edited";
            }

            Session::flash('fail', $message);

        }

        $this->removeTempImagefolder();

        return redirect()->route('admin.pages.index');

    }


    public function removeTempImagefolder()
    {
        Storage::disk('public')->deleteDirectory($this->tempImagePath);
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
        //gets image information for validation
        $error = 0;
   /*     list($width, $height, $type, $attr) = getimagesize( public_path($image) );
        //list($width, $height, $type, $attr) = getimagesize( $image );
        if ($width < 0)
        {
            $error = 1;
            $this->addError('banner', 'Yay width issue');
        }

        if ($height < 0)
        {
            $error = 1;
            $this->addError('banner', 'Yay height issue');
        }
*/
        return $error;
    }


    public function makeBannerImage($image)
    {
        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->bannerValidation($image) == FALSE)
        {

            $version = date("YmdHis");

            $this->banner = $image; //relative path in field
            $this->bannerOriginal = $image; //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));


            //assigns the preview filename
            $this->bannerImagePreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }


    public function render()
    {
        return view('livewire.admin.page-standard-form');
    }
}
