<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class PageStandardForm extends Component
{

    protected $listeners = ['make_banner_image' => 'makeBannerImage'];


    public $title, $slug, $type, $lead, $body;
    public $action;
    public $baseUrl;

    public $activeTab;

    public $banner;
    public $bannerOriginal;
    public $bannerImagePreview;

    public $tempImagePath;

    protected $rules = [
        'title' => 'required',
    ];

    protected $messages = [
        'slug.unique' => 'The slug has already been taken. Please modify your title',
    ];

    public function mount()
    {

        //preview images are saved a temp folder
        if (!empty(Auth::guard('admin')->page()->client))
        {
            $this->tempImagePath = Auth::guard('admin')->page()->client->subdomain;
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


        } elseif (in_array('edit', Request::segments() ) ){

            $this->action = "edit";

            $this->pageRef = Request::segments()[2];
            $page = $this->getPageDetails( $this->pageRef );

            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->lead = $page->pageable->lead;
            $this->body = $page->pageable->body;

            $banner = $this->getMedia('banner')->first();
            if ($banner)
            {
                $this->banner = $banner->getCustomProperty('folder'); //relative path in field
                $this->bannerOriginal =  '/storage' . $banner->getCustomProperty('folder'); //$banner->getFullUrl();
                $this->bannerImagePreview = $banner->getUrl('banner'); // retrieves URL of converted image
            }

        //if not 'edit' and not 'create'
        } else {
            abort(404);
        }


    }


    public function getUserDetails()
    {
        $pageService = new PageService();
        $page = $pageService->getPageDetails($this->pageRef);

        return $page;

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
        list($width, $height, $type, $attr) = getimagesize( public_path('/storage' . $image) );
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
            $this->bannerOriginal = '/storage' . $image; //relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_banner.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( 'storage' . $image ) )
                ->crop(Manipulations::CROP_CENTER, 2074, 798)
                ->save( public_path( 'storage\\'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->bannerImagePreview = '\storage\\'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }


    public function render()
    {
        return view('livewire.admin.page-standard-form');
    }
}
