<?php

namespace App\Http\Services\Spatie\MediaLibrary\Support\PathGenerator;

use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator
{
    /*
     * Get the path for the given media, relative to the root storage path.
     */
    public function getPath(Media $media): string
    {
        return $this->getBasePath($media).'/';
    }

    /*
     * Get the path for conversions of the given media, relative to the root storage path.
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getBasePath($media).'/conversions/';
    }

    /*
     * Get the path for responsive images of the given media, relative to the root storage path.
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getBasePath($media).'/responsive-images/';
    }

    /*
     * Get a unique base path for the given media.
     */
    protected function getBasePath(Media $media): string
    {

       /*  $path = public_path('media/'.getClientUuid().'/'.$media->uuid);

        if(!File::isDirectory($path)){
            return 'dc6da863-b595-4b3c-986d-51c6b0fb6dde/'.$media->uuid;
        } else {
            return getClientUuid().'/'.$media->uuid;
        } */

        return $media->uuid;
    }
}
