<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
//use Form;
use App\Models\Client;
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
            if (Session::get('adminAccessLevel') == 1){

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
            } elseif (Session::get('adminAccessLevel') == 2){

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
            } elseif (Session::get('adminAccessLevel') == 3){

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
                $actions = '<a href="'.route("admin.users.edit", ["user" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                $actions = '<a href="" class="edit btn btn-primary btn-sm">View User Data</a> ';
                $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';
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
     * @param \App\Models\Client  $client
     * @param \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client, Institution $institution)
    {
        //checks policy
        $this->authorize('create', User::class);

        $user = new User;

        return view('admin.pages.users.create', ['client' => $client, 'institution' => $institution, 'user' => $user ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\UserStoreRequest  $request
     * @param  \App\Models\Client  $client
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request, Client $client, Institution $institution)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        $validatedData['password'] = Hash::make($validatedData['password']);

        //creates the user
        $user = User::create($validatedData);

        return redirect()->route('admin.clients.institution.users.index', ['client' => $client, 'institution' => $institution])
            ->with('success','User created successfully');

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
    public function edit(Request $request, Client $client, Institution $institution, User $user)
    {


        //calls the Userpolicy update function to check authoridation
        $this->authorize('update', $user);

        return view('admin.pages.users.edit', ['client' => $client, 'institution' => $institution, 'user' => $user]);

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
    public function update(UserStoreRequest $request, Client $client, Institution $institution, User $user)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        //if the password field was left empty
        if (empty($validatedData['password'])){
            unset($validatedData['password']);
            unset($validatedData['confirm_password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        //updates the model
        $user->update($validatedData);

        return redirect()->route('admin.clients.institutions.users.index', ['client' => $client, 'institution' => $institution])
            ->with('success','User updated successfully');

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
}
