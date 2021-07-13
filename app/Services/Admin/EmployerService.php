<?php

namespace App\Services\Admin;

use Ramsey\Uuid\Uuid;
use App\Models\Employer;
use App\Models\ContentLive;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

Class EmployerService{

    public function getEmployerDetails($ref)
    {

        //if the Uuid passed is validdd
        if ( Uuid::isValid( $ref ))
        {
            $employer = Employer::where('uuid', '=', $ref)->firstOrFail();
        } else {
            abort(404);
        }

        return $employer;

    }



    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data)
    {

        if ($data->action == 'add')
        {

            //create the `article` record
            $employer = Employer::create([
                'name' => $data->name,
                'slug' => $data->slug,
                'website' => $data->website,
                'article_id' => $this->getLiveContentIdByUuid($data->employer_article),
            ]);

        } elseif ($data->action == 'edit'){

            $employer = Employer::where('uuid', $data->ref)->firstOrFail();

            //updates the resource
            $e = $employer->update([
                            'name' => $data->name,
                            'slug' => $data->slug,
                            'website' => $data->website,
                            'article_id' => $this->getLiveContentIdByUuid($data->employer_article),
                            ]);
        }

        if ($data->logo)
        {
            $this->addMediaToEmployer($data, 'logo', $employer, TRUE);
        }

        return $employer;

    }





    /**
     * addMediaToContent
     * clears collection if required
     * assign image to the employer
     *
     * @param  mixed $image
     * @param  mixed $type
     * @param  mixed $employer
     * @param  mixed $clearCollection
     * @return void
     */
    public function addMediaToEmployer($data, $type, $employer, $clearCollection=False)
    {

        //clears the collection for the piece of vacancy
        if ($clearCollection)
        {
            $employer->clearMediaCollection($type);
        }


        //if the image passed is an instance of media (ie already saved to DB)
        if ($data->logo instanceof Media)
        {
            $imagePath = $data->logo->getCustomProperty('folder');
        //else if media is a string
        } else {
            $imagePath = $data->logo;
        }

        $properties = ['folder' => $imagePath ];


        if ($type == 'logo') {
            $properties['alt'] = $data->employerLogo_alt;
        }

        if ($imagePath)
        {

            $employer->addMedia(public_path( $imagePath ))
                        ->preservingOriginal()
                        ->withCustomProperties($properties)
                        ->toMediaCollection($type);
        }

    }


    /**
     * delete
     *
     * @param  mixed $vacancy
     * @return void
     */
    public function delete(Employer $employer)
    {

        try
        {

            //removes the content
            $employer->delete();

        } catch (\exception $e) {

            return false;

        }

        return true;
    }


    /**
     * getLivePageIdByUuid
     *
     * @param  mixed $contentRef
     * @return void
     */
    public function getLiveContentIdByUuid($contentRef)
    {

        if (!empty($contentRef))
        {
            $data = ContentLive::select('id')->where('uuid', '=', $contentRef)->get()->first();

            return $data['id'];
        }

        return NULL;
    }


}

