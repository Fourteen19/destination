<?php

namespace App\Http\Controllers\Admin;

use \Illuminate\Support\Facades\DB;
//use Form;
use \Illuminate\Support\Facades\Hash;
use \Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Client;
use App\Models\Institution;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserStoreRequest;

class ClientInstitutionUserController extends Controller
{

    /**
     * index
     *
     * @param  \Symfony\Component\HttpFoundation\Request $request
     * @param  \App\Models\Client  $client
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Client $client, Institution $institution)
    {

        //current client
        $clientUuid = $client->uuid;

        //current institution
        $institutionUuid = $institution->uuid;

        if ($request->ajax()) {

//            $data = DB::select('select first_name, last_name, email, uuid from users where deleted_at IS NULL');

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

        return view('admin.pages.users.index', ['client'=>$client, 'institution'=>$institution]);
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
