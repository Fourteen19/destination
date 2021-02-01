<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Client;
use App\Models\SystemTag;
use App\Models\Institution;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\UserStoreRequest;

class UserController extends Controller
{

    /**
     * index
     *
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @param  \App\Models\Client  $client
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        //checks policy
        $this->authorize('list', User::class);

/*
        //current client
        $clientUuid = $client->uuid;

        //current institution
        $institutionUuid = $institution->uuid;

        if ($request->ajax()) {

            $data = DB::table('users')
                        ->select('id', 'first_name', 'last_name', 'email', 'uuid')
                        ->where('deleted_at', '=', NULL)
                        ->where('institution_id', '=', $institution->id)
                        ->get();

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->first_name." ".$row->last_name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('action', function($row) use ($clientUuid, $institutionUuid){

                    $actions = '<a href="'.route("admin.clients.institutions.users.edit", ["client" => $clientUuid, "institution" => $institutionUuid, "user" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
*/

        //server-side loading of data
        if ($request->ajax()) {

            //user type 1
            if (isClientAdvisor()){

                //gets the institution data based on the advisor's institution
                $institution = Institution::findOrFail(Auth::user()->institution_id);

                $items = DB::table('users')
                ->where('institution_id', '=', $institution->id)
                ->select(
                    DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                    "email",
                    'uuid'
                );

            //user type 2
            } elseif (isClientAdmin()){

                if (request()->has('institution')) {
                    if (!empty($request->get('institution'))){

                        //gets the institution based on uuid
                        $institution = Institution::where('uuid', '=', request('institution'))->select('id')->first();

                        //selects th institution's users
                        $items = DB::table('users')
                        ->where('institution_id', '=', $institution->id)
                        ->select(
                            DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                            "email",
                            'uuid'
                        );
                    }

                } else {

                    //when loading the screen, we set the list of users to nothing
                    $items = [];

                }

            //user type 3
            } elseif (isGlobalAdmin()){
                $items = [];
                if (request()->has('institution')) {

                    if (!empty($request->get('institution'))){

                        //gets the institution based on uuid
                        $institution = Institution::where('uuid', '=', request('institution'))->select('id')->first();

                        //selects th institution's users
                        $items = DB::table('users')
                        ->where('institution_id', '=', $institution->id)
                        ->select(
                            DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                            "email",
                            'uuid'
                        );
                    }

                } else {

                    //when loading the screen, we set the list of users to nothing
                    $items = [];

                }

            }


            return Datatables::of($items)

            //custom filterig. Overrides all filtering
            ->filter(function ($query) use ($request, $institution){

                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where(function($query) {
                            $query->where('users.first_name', 'LIKE', "%" . request('search.value') . "%");
                            $query->orWhere( 'users.last_name' , 'LIKE' , '%' . request('search.value') . '%');
                        });
                    }
                }

                //user type 1
                if (Session::get('adminAccessLevel') == 1){

                //user type 2 OR 3
                } elseif (in_array(Session::get('adminAccessLevel'), [2, 3])) {

                    if (request()->has('institution')) {
                        if (!empty($request->get('institution'))){

                            $query->where(function($query) use ($institution){
                                $query->where('institution_id', '=', $institution->id );
                            });
                        }
                    }

                }

            })
            ->addColumn('action', function($row) {
                $actions = '<a href="'.route("admin.users.edit", ["user" => $row->uuid]).'" class="edit mydir-dg btn mx-1">Edit</a>';
                $actions .= '<a href="'.route("admin.users.user-data", ["user" => $row->uuid]).'" class="edit mydir-dg btn mx-1">View User Data</a>';
                $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.users.index');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', User::class);

        $user = new User;

        //gets all the tags of type 'subject'
        $tagsSubjects = SystemTag::where('type', 'subject')->get();
        $tagsLscs = SystemTag::where('type', 'career_readiness')->get();
        $tagsRoutes = SystemTag::where('type', 'route')->get();
        $tagsYears = SystemTag::where('type', 'year')->get();
        $tagsSectors = SystemTag::where('type', 'sector')->get();



        $userSubjectTags = $user->tagsWithType('subject'); // returns a collection
        $userLscsTags = $user->tagsWithType('career_readiness');
        $userRouteTags = $user->tagsWithType('route');
        $userYearTags = $user->tagsWithType('year');
        $userSectorTags = $user->tagsWithType('sector');


        return view('admin.pages.users.create', ['user' => $user,
                            'tagsSubjects' => $tagsSubjects,
                            'userSubjectTags' => $userSubjectTags,
                            'tagsLscs' => $tagsLscs,
                            'userLscsTags' => $userLscsTags,
                            'tagsRoutes' => $tagsRoutes,
                            'userRouteTags' => $userRouteTags,
                            'tagsYears' => $tagsYears,
                            'userYearTags' => $userYearTags,
                            'tagsSectors' => $tagsSectors,
                            'userSectorTags' => $userSectorTags,
        ]);

//        return view('admin.pages.users.create', ['user' => $user ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

        //checks policy
        $this->authorize('create', Admin::class);

        // Will return only validated data
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            $validatedData['password'] = Hash::make($validatedData['password']);

            //creates the user
            $user = User::create($validatedData);

            //attaches tags to the content
            $user->attachTags( $validatedData['tagsSubjects'], 'subject' );

            DB::commit();

            return redirect()->route('admin.users.index')->with('success','User created successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.users.index')
                            ->with('error', 'An error occured, your user could not be created');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\Client  $client
     * @param  App\Models\Institution  $id
     * @param  App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {

        //calls the Userpolicy update function to check authoridation
        $this->authorize('update', $user);

        $user->system_id = "121212";

        //gets all the tags
        $tagsSubjects = SystemTag::where('type', 'subject')->get();
        $tagsLscs = SystemTag::where('type', 'career_readiness')->get();
        $tagsRoutes = SystemTag::where('type', 'route')->get();
        $tagsYears = SystemTag::where('type', 'year')->get();
        $tagsSectors = SystemTag::where('type', 'sector')->get();

        //gets the tags allocated to the content
        $userSubjectTags = $user->tagsWithType('subject'); // returns a collection
        $userLscsTags = $user->tagsWithType('career_readiness');
        $userRouteTags = $user->tagsWithType('route');
        $userYearTags = $user->tagsWithType('year');
        $userSectorTags = $user->tagsWithType('sector');


        return view('admin.pages.users.edit', ['user' => $user,
                            'tagsSubjects' => $tagsSubjects,
                            'userSubjectTags' => $userSubjectTags,
                            'tagsLscs' => $tagsLscs,
                            'userLscsTags' => $userLscsTags,
                            'tagsRoutes' => $tagsRoutes,
                            'userRouteTags' => $userRouteTags,
                            'tagsYears' => $tagsYears,
                            'userYearTags' => $userYearTags,
                            'tagsSectors' => $tagsSectors,
                            'userSectorTags' => $userSectorTags,
        ]);


        //return view('admin.pages.users.edit', ['user' => $user]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\Admin\UserStoreRequest  $request
     * @param  App\Models\Client  $client
     * @param  App\Models\Institution  $institution
     * @param  App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreRequest $request, User $user)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //if the password field was left empty
            if (empty($validatedData['password'])){
                unset($validatedData['password']);
                unset($validatedData['confirm_password']);
            } else {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }

            //updates the model
            $user->update($validatedData);


            //if the tag is set
            if (!isset($validatedData['tagsSubjects']))
            {
                //remove tags
                $user->syncTagsWithType([], 'subject');
            } else {
                //attaches tags to the content
                $user->syncTagsWithType( $validatedData['tagsSubjects'], 'subject' );
            }

            //if the tag is set
            if (!isset($validatedData['tagsLscs']))
            {
                //remove tags
                $user->syncTagsWithType([], 'career_readiness');
            } else {
                //attaches tags to the content
                $user->syncTagsWithType( $validatedData['tagsLscs'], 'career_readiness' );
            }

            //if the tag is set
            if (!isset($validatedData['tagsRoutes']))
            {
                //remove tags
                $user->syncTagsWithType([], 'route');
            } else {
                //attaches tags to the content
                $user->syncTagsWithType( $validatedData['tagsRoutes'], 'route' );
            }

            //if the tag is set
            if (!isset($validatedData['tagsYears']))
            {
                //remove tags
                $user->syncTagsWithType([], 'year');
            } else {
                //attaches tags to the content
                $user->syncTagsWithType( $validatedData['tagsYears'], 'year' );
            }

            //if the tag is set
            if (!isset($validatedData['tagsSectors']))
            {
                $user->syncTagsWithType([], 'sector');
            } else {
                //attaches tags to the content
                $user->syncTagsWithType( $validatedData['tagsSectors'], 'sector' );
            }

            DB::commit();

            return redirect()->route('admin.users.index')
                ->with('success','You user has been updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.users.index')
                            ->with('error', 'An error occured, your user could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function import()
    {
        return view('admin.pages.users.import');
    }


    public function export()
    {
        return view('admin.pages.users.export');
    }

    public function userData()
    {
        return view('admin.pages.users.data');
    }




}
