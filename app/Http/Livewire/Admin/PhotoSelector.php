<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Image\Image;
use App\Models\Admin\Admin;
use Illuminate\Support\Str;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\Storage;

class PhotoSelector extends Component
{

    protected $listeners = ['make_photo_image' => 'makePhotoImage', ];

    public $photo;
    public $photoOriginal;
    public $photoPreview;

    public $tempImagePath;


    protected $rules = [
        'banner' => 'required|file_exists',
    ];


    public function mount($uuid, $error, $action, $photo)
    {

        $admin = Admin::where('uuid', $uuid)->first();

        $this->tempImagePath = $this->tempImagePath.'/preview_images/'.Str::random(32);
        Storage::disk('public')->makeDirectory($this->tempImagePath);

        if ($error == True)
        {

            if ($action == "add")
            {

                $this->photo = $photo;
                $this->photoOriginal = (!empty($photo)) ? parse_encode_url(url($photo)) : "";
                $this->makePhotoImage($photo);

            //} elseif ($action == "edit") {

                $this->photo = $photo;
                $this->photoOriginal = (!empty($photo)) ? parse_encode_url(url($photo)) : "";
                $this->makePhotoImage($photo);

            }


        } else {

            if ($action == "add")
            {

                $this->photo = "";
                $this->photoOriginal = "";
                $this->photoPreview = "";

            } elseif ($action == "edit") {

                if ($admin)
                {

                    $photo = $admin->getMedia('photo')->first();

                    if ($photo)
                    {
                        $photoUrl = parse_encode_url($photo->getUrl());
                        $this->photo = $photo->getCustomProperty('folder'); //relative path in field
                        $this->photoOriginal = $photoUrl;//$photo->getCustomProperty('folder'); //$photo->getFullUrl();
                        $this->photoPreview = parse_encode_url($photo->getUrl('small')); // retrieves URL of converted image
                    }

                }

            }

        }

    }



    /**
     * Validate single a field
     */
    public function updated($propertyName)
    {


        if ($propertyName == "photo")
        {

            $this->validate($this->rules, $this->messages);

        }

    }



    /**
     * bannerValidation
     * Custom validation on the banner
     *
     * @param  mixed $image
     * @return void
     */
    public function photoValidation($image)
    {

        $this->resetErrorBag('photo');

        //gets image information for validation
        $error = 0;
        list($width, $height, $type, $attr) = getimagesize( public_path($image) );

        $image_path = image_path_fix($image);
        $filesize = \File::size( public_path($image_path) );

        $dimensionsErrorMessage = __('ck_admin.admins.photo.upload.error_messages.dimensions', ['width' => config('global.admins.photo.upload.required_size.width'), 'height' => config('global.admins.photo.upload.required_size.height') ]);
        $filesizeErrorMessage = __('ck_admin.admins.photo.upload.error_messages.filesize', ['max_filesize' => config('global.admins.photo.upload.max_filesize') ]);

        //dimension validation
         if ( ($width < config('global.admins.photo.upload.required_size.width')) || ($height < config('global.admins.photo.upload.required_size.height')) )
        {
            $error = 1;
            $this->addError('photo', $dimensionsErrorMessage);
        }

        //image file size in KB
        if ( $filesize > config('global.admins.photo.upload.max_filesize') * 1024 )
        {

            $error = 1;
            $this->addError('photo', $filesizeErrorMessage);
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
                $this->addError('photo', __('ck_admin.admins.photo.upload.error_messages.type') );
            }

        }

        return $error;
    }




    public function makePhotoImage($image)
    {

        //Returns information about a file path
        $fileDetails = pathinfo($image);

        if ($this->photoValidation($image) == FALSE)
        {

            $this->resetErrorBag('photo');

            $version = date("YmdHis");

            $this->photo = $image; //relative path in field

            //split the string, encode the parts and join the string together again.
            $this->photoOriginal = implode('/', array_map('rawurlencode', explode('/', $image)));//relative path of image selected. displays the image

            //generates preview filename
            $imageName = "preview_photo.".$fileDetails['extension'];

            //generates Image conversion
            Image::load (public_path( $image ) )
                ->crop(Manipulations::CROP_CENTER, 300, 300)
                ->save( public_path( 'storage/'.$this->tempImagePath.'/'.$imageName ));

            //assigns the preview filename
            $this->photoPreview = '/storage/'.$this->tempImagePath.'/'.$imageName.'?'.$version;//versions the file to prevent caching

        }

    }


    public function render()
    {
        return view('livewire.admin.photo-selector');
    }
}
