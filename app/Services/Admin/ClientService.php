<?php

namespace App\Services\Admin;

use App\Models\Client;
use App\Models\ClientSettings;
use App\Models\DashboardStats;
use App\Models\HomepageSettings;
use Illuminate\Support\Facades\DB;
use App\Models\StaticClientContent;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Class ClientService
{

    /**
     * createClientList
     * Generates the dropdown used in admin listing the clients
     *
     * @return void
     */
    public function createClientList($initiate = FALSE)
    {

        //selects all the clients
        $clients = Client::select('id', 'uuid', 'name', 'subdomain')->orderBy('name', 'ASC')->get()->toArray();

        $clientsList = [];
        foreach($clients as $key => $value)
        {
            $clientsList[ $value['uuid'] ] = $value['name'];

            //sets the first client as default client to manage
            if ( ($initiate) && ($key == 0) )
            {
                session(['adminClientSelectorSelection' => $value['uuid'] ]);
                session(['adminClientSelectorSelected'=> $value['id'] ]);
                session(['client' => $value]);
            }
        }

        //we store in a session all the current clients to appear in the client selector
        session(['all_clients' =>  $clientsList]);

    }




    public function createClient($validatedData)
    {

        DB::beginTransaction();

        try  {

            //creates the client
            $client = Client::create($validatedData);

            $client->clientSettings()->save( new ClientSettings() );

            $client->staticClientContent()->save( new StaticClientContent() );

            $client->dashboardStats()->save( new DashboardStats(['year_id' => app('currentYear')]) );

            for ($year=7;$year<=14;$year++)
            {
                $client->homepageSettings()->save( new HomepageSettings(['school_year' => $year]) );
            }


            //creates the homepage
            $pageHomepageService = new PageHomepageService();
            $homepage = $pageHomepageService->addNewClient($client->id);

            //make the home page live
            $pageService = new PageService();
            $pageService->makeLive($homepage);



            //need to add the folder creation for images
            //

            DB::commit();

            return True;

        } catch (\Exception $e) {

            DB::rollback();

            Log::error($e);

            return False;
        }

    }






    public function getClientDetails($uuid)
    {
        $client = Client::select('name', 'subdomain', 'suspended')->where('uuid', '=', $uuid)->first()->toArray();
        if (!$client)
        {
            abort(403);
        } else {
            return $client;
        }
    }




    public function getClientNameForAdminPages()
    {

        if (isGlobalAdmin()){

            //check if the route is global or client
            //$contentOwner = (Route::is('admin.global*')) ? "Global" : Session::get('client')['name'] ;
            if (Route::is('admin.global*')){
                $contentOwner = "Global";
            } else {

                //determine if present in the session and is not null
                if ( Session::has('adminClientSelectorSelection') )
                {
                    $contentOwner = Session::get('all_clients')[ Session::get('adminClientSelectorSelection') ];
                } else {
                    $contentOwner = "Undefined";
                }

            }

        } else {
            $contentOwner = Session::get('adminClientName');

        }

        return $contentOwner;
    }


    /**
     * attachImage
     *
     * @param  mixed $data
     * @param  mixed $collectionName
     * @param  mixed $model
     * @return void
     */
    private function attachImage(Array $data, String $collectionName, $model)
    {

        $model->clearMediaCollection($collectionName); // all media will be deleted

        $model->addMedia( public_path($data['url']) )
                    ->preservingOriginal()
                    ->withCustomProperties(['folder' => $data['url'],
                                            'alt' => $data['alt'] ])
                    ->toMediaCollection($collectionName);

    }


    /**
     * storeSettings
     *
     * Stores in the DB the client settings
     *
     * @return void
     */
    public function storeSettings($data)
    {

        $client = Client::select('id','uuid')->where('uuid', $data->uuid)->with('clientSettings')->firstorfail();

        $clientSettings = $client->clientSettings;


        $clientSettings->chat_app = $data->chat_app;
        $clientSettings->font_url = $data->font_url;
        $clientSettings->font_family = $data->font_family;
        $clientSettings->colour_bg1 = $data->colour_bg1;
        $clientSettings->colour_bg2 = $data->colour_bg2;
        $clientSettings->colour_bg3 = $data->colour_bg3;
        $clientSettings->colour_txt1 = $data->colour_txt1;
        $clientSettings->colour_txt2 = $data->colour_txt2;
        $clientSettings->colour_txt3 = $data->colour_txt3;
        $clientSettings->colour_txt4 = $data->colour_txt4;
        $clientSettings->colour_link1 = $data->colour_link1;
        $clientSettings->colour_link2 = $data->colour_link2;
        $clientSettings->colour_button1 = $data->colour_button1;
        $clientSettings->colour_button2 = $data->colour_button2;
        $clientSettings->colour_button3 = $data->colour_button3;
        $clientSettings->colour_button4 = $data->colour_button4;

        $clientSettings->save();


        //attaches a logo image
        if (!empty($data->logo))
        {
            $this->attachImage(['url' => $data->logo, 'alt' => $data->logo_alt], 'logo', $clientSettings);

            $logo = $clientSettings->getMedia('logo')->first();

            $logoData = ['logo' => [ 'url' => parse_encode_url($logo->getUrl()),
                                     'alt' => $logo->getCustomProperty('alt'),
                                    ]
                        ];

        } else {

            $logoData = ['logo' => ['url' => '',
                                    'alt' => '',
                                    ]
                        ];
        }



        $this->cacheClientSettings( $client->id,
                                    array_merge([
                                        'chat_app' => $clientSettings->chat_app,
                                        'font_url' => $clientSettings->font_url,
                                        'font_family' => $clientSettings->font_family,
                                        'colour_bg1' => $clientSettings->colour_bg1,
                                        'colour_bg2' => $clientSettings->colour_bg2,
                                        'colour_bg3' => $clientSettings->colour_bg3,
                                        'colour_txt1' => $clientSettings->colour_txt1,
                                        'colour_txt2' => $clientSettings->colour_txt2,
                                        'colour_txt3' => $clientSettings->colour_txt3,
                                        'colour_txt4' => $clientSettings->colour_txt4,
                                        'colour_link1' => $clientSettings->colour_link1,
                                        'colour_link2' => $clientSettings->colour_link2,
                                        'colour_button1' => $clientSettings->colour_button1,
                                        'colour_button2' => $clientSettings->colour_button2,
                                        'colour_button3' => $clientSettings->colour_button3,
                                        'colour_button4' => $clientSettings->colour_button4,

                                    ], $logoData)
                                );


    }








    /******************* */


    public function cacheClientSettings($clientId, $data)
    {
        Redis::set('client:'.$clientId.':client-settings', serialize($data));
    }



    public function getCachedClientSettings($clientId)
    {
        return unserialize(Redis::get('client:'.$clientId.':client-settings'));
    }



/*     public function getClientSettings()
    {
        return $this->getCachedClientSettings(1);
    } */

    /*********************** */


}
