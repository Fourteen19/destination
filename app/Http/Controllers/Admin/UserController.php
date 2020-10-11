<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
//use Form;
use App\Models\Client;
use App\Models\Institution;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Hash;
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
        if ($request->ajax()) {


            $search = $request->input('search.value');
            
            /*
            $count_total = DB::table('users')->count();
          
            $count_filter = DB::table('users')
                              ->where(   'users.first_name' , 'LIKE' , '%'.$search.'%')
                              ->orWhere( 'users.last_name' , 'LIKE' , '%'.$search.'%')
                              ->orWhere( 'users.email' , 'LIKE' , '%'.$search.'%')
                              ->count();
*/
            $items= DB::table('users')
            ->select(
                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                "email",
                'uuid'
            );
            //->take(15);

            return Datatables::of($items)
/*
            ->with([
                "recordsTotal" => $count_total,
                "recordsFiltered" => $count_filter,
            ])
*/

/*
                ->filterColumn('name', function($query, $keyword) {
                        $sql = "CONCAT(users.first_name,' ',users.last_name)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('email', function($query, $keyword) {
                    $sql = "users.email like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
  */  

            ->filter(function ($query) use ($request){
                
                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where(function($query) {
                            $query->where('users.first_name', 'LIKE', "%" . request('search.value') . "%");
                            $query->orWhere( 'users.last_name' , 'LIKE' , '%' . request('search.value') . '%');
                        });    
                    }
                }

                if (request()->has('name')) {
                    if (!empty($request->get('name'))){
                        $query->where(function($query) {
                            $query->where('institution_id', '=', request('name') );
                        });
                    }
                }

            })
            ->addColumn('action', function($row) {
                $actions = '<a href="'.route("admin.users.edit", ["user" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';
                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);


                              



            /*
            $users = User::select(['first_name', 'last_name', 'email', 'uuid'])->get();

            return Datatables::of($users)
                ->filter(function ($instance) use ($request) {
                  
                    if ($request->has('name')) {
                        if (!empty($request->get('name'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['name'], $request->get('name')) ? true : false;
                            });
                        }
                    }
                    //dd($instance->collection);

                    if ($request->has('email')) {
                        if (!empty($request->get('email'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['email'], $request->get('email')) ? true : false;
                            });
                        }
                    }

                    if ($request->has('search')) {
                        if (!empty($request->get('search'))){
                            $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                return Str::contains($row['name'], $request->get('name')) ? true : false;
                            });
                        }
                    }
                })
                ->addColumn('name', function($row){
                    return $row->first_name." ".$row->last_name;
                })
                ->addColumn('email', function($row){
                    return $row->email;
                })
                ->addColumn('action', function($row) {

                    $actions = '<a href="'.route("admin.users.edit", ["user" => $row->uuid]).'" class="edit btn btn-primary btn-sm">Edit</a> ';
                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->uuid.'">Delete</button>';

                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
*/
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
