<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Institution;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Services\Admin\UserService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use \Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UsersImportRequest;

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

        $items = [];

        $institution = NULL;

        //server-side loading of data
        if ($request->ajax()) {

            //saves the institution used in the session so it can be reused automatically if the user returns to filter screen
            $request->session()->put('institution_filter', $request->institution);


            //user type 1
            //if (isClientAdvisor()){
            if (isClientTeacher(Auth::guard('admin')->user()))
            {

                //gets the institution data based on the advisor's institution
                // $institution = Institution::findOrFail(Auth::user()->institution_id);

                //display users that belong to the institution owned by the advisor
                $items = DB::table('users')
                ->whereIn('institution_id', Auth::guard('admin')->user()->compileInstitutionsToArray())
                ->select(
                    DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                    "email",
                    'uuid'
                )
                ->where('type', '=','user')
                ->where('deleted_at', '=', NULL);


            } elseif (  adminHasRole(Auth::guard('admin')->user(), config('global.admin_user_type.Advisor')) ) {

                //gets the institution based on uuid and client ID
                $institution = Institution::where('uuid', '=', request('institution'))->CanOnlySeeClientInstitutions(Auth::guard('admin')->user()->client_id)->select('id')->first();

                //if institution found
                if ($institution)
                {

                    //display users that belong to the institution owned by the advisor
                    $items = DB::table('users')
                    ->where('institution_id', '=', $institution->id)
                    ->whereIn('institution_id', Auth::guard('admin')->user()->compileInstitutionsToArray())
                    ->select(
                        DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                        "email",
                        'uuid'
                    )
                    ->where('type', '=','user')
                    ->where('deleted_at', '=', NULL);

                }

            //user type 2
            } elseif (isClientAdmin() ){

                if (request()->has('institution')) {
                    if (!empty($request->get('institution'))){

                        //gets the institution based on uuid and client ID
                        $institution = Institution::where('uuid', '=', request('institution'))->CanOnlySeeClientInstitutions(Auth::guard('admin')->user()->client_id)->select('id')->first();

                        //if institution found
                        if ($institution)
                        {
                            //selects th institution's users
                            $items = DB::table('users')
                            ->where('institution_id', '=', $institution->id)
                            ->select(
                                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                                "email",
                                'uuid'
                            )
                            ->where('type', '=','user')
                            ->where('deleted_at', '=', NULL);
                        }
                    }

                }

            //user type 3
            } elseif (isGlobalAdmin()){

                if (request()->has('institution')) {
                    if (!empty($request->get('institution'))){

                        if ($request->get('institution') == 'unallocated')
                        {
                            $institution = $institutionId = NULL;
                        } else {
                            //gets the institution based on uuid
                            $institution = Institution::where('uuid', '=', request('institution'))->select('id')->first();
                            $institutionId = $institution->id;
                        }


                        if ( ($institution) || ($request->get('institution') == 'unallocated') )
                        {

                            //selects th institution's users
                            $items = DB::table('users')
                            ->where('institution_id', $institutionId)
                            ->select(
                                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                                "email",
                                'uuid'
                            )
                            ->where('type', '=','user')
                            ->where('deleted_at', '=', NULL);
                        }
                    }

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
/*
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
*/
            })
            ->addColumn('action', function($row) {

                $actions = '';

                if (Auth::guard('admin')->user()->hasAnyPermission('user-create')) {
                    $actions .= '<a href="'.route("admin.users.edit", ["user" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="far fa-edit"></i></a>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('user-data-view')) {
                    $actions .= '<a href="'.route("admin.users.user-data", ["user" => $row->uuid]).'" class="edit mydir-dg btn mx-1"><i class="fas fa-chart-bar"></i></a>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('user-delete')) {
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }
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

        return view('admin.pages.users.create', ['action' => 'add']);

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

        return view('admin.pages.users.edit', ['action' => 'edit', 'userUuid' => $user->uuid]);

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
                ->with('success','Your user has been updated successfully');

        }
        catch (\Exception $e) {

            Log::error($e);

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
    public function destroy(Request $request, User $user)
    {

        //check policy authorisation
        $this->authorize('delete', $user);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $userId = $user->id;

                $user->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your User has been successfully deleted!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your User could not be deleted, Try Again!";
            }

        }

        return response()->json($data_return, 200);

    }



    public function import( )
    {
        //check policy authorisation
        $this->authorize('import', User::class);

        $contentOwner = app('clientService')->getClientNameForAdminPages();

        return view('admin.pages.users.import', ['contentOwner' => $contentOwner]);
    }



    public function importing(UsersImportRequest $request)
    {

        //check policy authorisation
        $this->authorize('import', User::class);

        $file = $request->file('importFile');
        $clientId = getClientId();

        $institution = Institution::select('id')->where('uuid', $request->get('institution'))
                                                ->where('client_id', $clientId)->first()->toArray();

        if ($institution){

            $import = new UsersImport($clientId, $institution['id']);
            $import->import($file);

            $nbImports = $import->getRowCount();
            if ($nbImports <= 1)
            {
                $successString = $nbImports.' user has been created.';
            } else {
                $successString = $nbImports.' users have been created.';
            }

            return back()->withSuccess('File imported successfully. '.$successString);

        } else {
            abort(404);
        }
    }



    public function export()
    {
        return view('admin.pages.users.export');
    }


    /**
     * userData
     *
     * @param  mixed $userService
     * @param  mixed $user
     * @return void
     */
    public function userData(UserService $userService, User $user)
    {

        //check policy authorisation
        $this->authorize('viewData', $user);

        $data = $userService->getUserdata($user);

        return view('admin.pages.users.data', compact('data') );
    }




    public function batchTransfer(Request $request)
    {
        //checks policy
        $this->authorize('list', User::class);

        $items = [];

        $institution = NULL;

        //server-side loading of data
        if ($request->ajax()) {

            //saves the institution used in the session so it can be reused automatically if the user returns to filter screen
            $request->session()->put('institution_filter', $request->institution);

            //user type 1
            if (isClientAdvisor()){

                //gets the institution data based on the advisor's institution
                // $institution = Institution::findOrFail(Auth::user()->institution_id);

                $year = $request->get('year');

                //display users that belong to the institution owned by the advisor
                $items = DB::table('users')
                ->whereIn('institution_id', Auth::guard('admin')->user()->compileInstitutionsToArray())
                ->where('school_year', $year)
                ->select(
                    DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                    "email",
                    'uuid'
                )
                ->where('type', '=','user')
                ->where('deleted_at', '=', NULL);

            //user type 2
            } elseif (isClientAdmin()){

                if ( (request()->has('institution')) && (request()->has('year')) )
                {

                    if ( (!empty($request->get('institution'))) && (!empty($request->get('year'))) )
                    {

                        //gets the institution based on uuid and client ID
                        $institution = Institution::where('uuid', '=', request('institution'))->CanOnlySeeClientInstitutions(Auth::guard('admin')->user()->client_id)->select('id')->first();

                        $year = $request->get('year');

                        //if institution found
                        if ($institution)
                        {
                            //selects th institution's users
                            $items = DB::table('users')
                            ->where('institution_id', '=', $institution->id)
                            ->where('school_year', $year)
                            ->select(
                                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                                "email",
                                'uuid'
                            )
                            ->where('type', '=','user')
                            ->where('deleted_at', '=', NULL);
                        }
                    }

                }

            //user type 3
            } elseif (isGlobalAdmin()){

                if ( (request()->has('institution')) && (request()->has('year')) )
                {

                    if ( (!empty($request->get('institution'))) && (!empty($request->get('year'))) )
                    {

                        if ($request->get('institution') == 'unallocated')
                        {
                            $institution = $institutionId = NULL;
                        } else {
                            //gets the institution based on uuid
                            $institution = Institution::where('uuid', '=', request('institution'))->select('id')->first();
                            $institutionId = $institution->id;
                        }

                        $year = $request->get('year');

                        if ( ( ($institution) || ($request->get('institution') == 'unallocated') ) && ($year) )
                        {

                            //selects th institution's users
                            $items = DB::table('users')
                            ->where('institution_id', $institutionId)
                            ->where('school_year', $year)
                            ->select(
                                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                                "email",
                                'uuid'
                            )
                            ->where('type', '=','user')
                            ->where('deleted_at', '=', NULL);
                        }


                    }

                }

            }




            return Datatables::of($items)
            ->addColumn('select', function($row){
                return '<input type="checkbox" value="'.$row->uuid.'" class="chck" name="users[]" />';
            })
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
/*
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
*/
            })
            ->addColumn('action', function($row) {

                $actions = '';
                return $actions;

            })
            ->rawColumns(['select', 'action'])
            ->make(true);

        }

        return view('admin.pages.users.batch-transfer');

    }



    public function batchDelete(Request $request)
    {
        //checks policy
        $this->authorize('list', User::class);

        $items = [];

        $institution = NULL;

        //server-side loading of data
        if ($request->ajax()) {

            //saves the institution used in the session so it can be reused automatically if the user returns to filter screen
            $request->session()->put('institution_filter', $request->institution);

            //user type 1
            if (isClientAdvisor()){

                //gets the institution data based on the advisor's institution
                // $institution = Institution::findOrFail(Auth::user()->institution_id);

                $year = $request->get('year');

                //display users that belong to the institution owned by the advisor
                $items = DB::table('users')
                ->whereIn('institution_id', Auth::guard('admin')->user()->compileInstitutionsToArray())
                ->where('school_year', $year)
                ->select(
                    DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                    "email",
                    'uuid'
                )
                ->where('type', '=','user')
                ->where('deleted_at', '=', NULL);

            //user type 2
            } elseif (isClientAdmin()){

                if ( (request()->has('institution')) && (request()->has('year')) )
                {

                    if ( (!empty($request->get('institution'))) && (!empty($request->get('year'))) )
                    {

                        //gets the institution based on uuid and client ID
                        $institution = Institution::where('uuid', '=', request('institution'))->CanOnlySeeClientInstitutions(Auth::guard('admin')->user()->client_id)->select('id')->first();

                        $year = $request->get('year');

                        //if institution found
                        if ($institution)
                        {
                            //selects th institution's users
                            $items = DB::table('users')
                            ->where('institution_id', '=', $institution->id)
                            ->where('school_year', $year)
                            ->select(
                                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                                "email",
                                'uuid'
                            )
                            ->where('type', '=','user')
                            ->where('deleted_at', '=', NULL);
                        }
                    }

                }

            //user type 3
            } elseif (isGlobalAdmin()){

                if ( (request()->has('institution')) && (request()->has('year')) )
                {

                    if ( (!empty($request->get('institution'))) && (!empty($request->get('year'))) )
                    {

                        if ($request->get('institution') == 'unallocated')
                        {
                            $institution = $institutionId = NULL;
                        } else {
                            //gets the institution based on uuid
                            $institution = Institution::where('uuid', '=', request('institution'))->select('id')->first();
                            $institutionId = $institution->id;
                        }

                        $year = $request->get('year');

                        if ( ( ($institution) || ($request->get('institution') == 'unallocated') ) && ($year) )
                        {

                            //selects th institution's users
                            $items = DB::table('users')
                            ->where('institution_id', $institutionId)
                            ->where('school_year', $year)
                            ->select(
                                DB::raw("CONCAT(first_name, ' ', last_name) AS name"),
                                "email",
                                'uuid'
                            )
                            ->where('type', '=','user')
                            ->where('deleted_at', '=', NULL);
                        }


                    }

                }

            }




            return Datatables::of($items)
            ->addColumn('select', function($row){
                return '<input type="checkbox" value="'.$row->uuid.'" class="chck" name="users[]" />';
            })
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
/*
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
*/
            })
            ->addColumn('action', function($row) {

                $actions = '';
                return $actions;

            })
            ->rawColumns(['select', 'action'])
            ->make(true);

        }

        return view('admin.pages.users.batch-delete');

    }

}
