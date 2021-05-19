<?php

namespace App\Services\Admin;

use Ramsey\Uuid\Uuid;
use App\Models\Client;
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class VacancyService
{




    /**
     * getVacancyDetails
     *
     * @param  mixed $pageRef
     * @return void
     */
    public function getVacancyDetails($ref)
    {

        //if the Uuid passed is valid
        if ( Uuid::isValid( $ref ))
        {

            //if global admin
            if (isGlobalAdmin()){
                $page = Page::where('uuid', '=', $ref)->firstOrFail();

            //else if client page
            } else if ( (isClientAdmin()) || (isClientAdvisor()) ) {
                $page = Page::where('uuid', '=', $ref)->ForClient( Auth::guard('admin')->user()->client_id)->firstOrFail();

            //else
            } else {
                abort(404);
            }

        } else {
            abort(404);
        }

        return $page;

    }




    /**
     * createResource
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function createResource($validatedData)
    {
        //dd($validatedData);

        //all clients
        $all_clients = 'N';
        if (isset($validatedData['all_clients']))
        {
            if ($validatedData['all_clients'] == 'Y') {
                $all_clients = 'Y';
            }
        }

        $resourceData = ['filename' => $validatedData['filename'],
                         'description' => $validatedData['description'],
                         'all_clients' => $all_clients,
                         'admin_id' => Auth::guard('admin')->user()->id,
                        ];


        $resource = Resource::create($resourceData);


        //save the individual clients allocations
        if ( (isset($validatedData['clients'])) && ($all_clients == 'N') )
        {
            $clientsUuid = $validatedData['clients'];

            //collections of selected clients ids
            $selectedClients = Client::select('id')
                                        ->whereIn('uuid', $clientsUuid)
                                        ->get();

            //allocate the resource to the selected clients
            $resource->clients()->sync($selectedClients);

        }

        //Assigns the media to the resource
        $resource->clearMediaCollection('resource');

        //removes slash, from /storage/... to storage/...
        $filePath = str_replace("/storage", "storage", $validatedData['customFile_label']);

        //allocates the media
        $resource->addMedia($filePath)
                 ->preservingOriginal()
                 ->withCustomProperties(['folder' => $filePath])
                 ->toMediaCollection('resource');


    }




    /**
     * updateResource
     *
     * @param  mixed $validatedData
     * @return void
     */
    public function updateResource(Resource $resource, $validatedData)
    {

        $all_clients = 'N';
        if (isset($validatedData['all_clients']))
        {
            if ($validatedData['all_clients'] == 'Y') {
                $all_clients = 'Y';
                $resource->clients()->detach();
            }
        }

        $resourceData = ['filename' => $validatedData['filename'],
                         'description' => $validatedData['description'],
                         'all_clients' => $all_clients,
                         'admin_id' => Auth::guard('admin')->user()->id,
                        ];


        $resource->update($resourceData);

        //dd($validatedData['clients']);
        //individual clients
        if ( (isset($validatedData['clients'])) && ($all_clients == 'N') )
        {

            $clientsUuid = $validatedData['clients'];

            //collections of selected clients ids
            $selectedClients = Client::select('id')
                                        ->whereIn('uuid', $clientsUuid)
                                        ->get();

            //allocate the resource to the selected clients
            $resource->clients()->sync($selectedClients);

        }



        //Assigns the media to the resource
        $resource->clearMediaCollection('resource');

        //removes slash, from /storage/... to storage/...
        $filePath = str_replace("/storage", "storage", $validatedData['customFile_label']);

        //allocates the media
        $resource->addMedia($filePath)
                 ->preservingOriginal()
                 ->withCustomProperties(['folder' => $filePath])
                 ->toMediaCollection('resource');



    }



    public function delete(Resource $resource)
    {

        try
        {

            //removes the page
            $resource->delete();

        } catch (\Exception $e) {

            return false;

        }

        return true;

    }

}
