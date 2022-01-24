<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\Resource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class ResourceService
{


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

        $work_experience = 'N';
        if (isset($validatedData['work_experience']))
        {
            if ($validatedData['work_experience'] == 'Y') {
                $work_experience = 'Y';
            }
        }

        $resourceData = ['filename' => $validatedData['filename'],
                         'description' => $validatedData['description'],
                         'all_clients' => $all_clients,
                         'work_experience' => $work_experience,
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

        $work_experience = 'N';
        if (isset($validatedData['work_experience']))
        {
            if ($validatedData['work_experience'] == 'Y') {
                $work_experience = 'Y';
            }
        }

        $resourceData = ['filename' => $validatedData['filename'],
                         'description' => $validatedData['description'],
                         'all_clients' => $all_clients,
                         'work_experience' => $work_experience,
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

            Log::error($e);

            return false;

        }

        return true;

    }

}
