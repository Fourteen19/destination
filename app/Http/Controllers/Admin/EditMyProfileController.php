<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\UserService;
use App\Http\Controllers\Controller;
use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\EditMyProfileStoreRequest;

class EditMyProfileController extends Controller
{

    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $admin = Admin::findorfail( Auth::guard('admin')->user()->id );

        return view('admin.pages.edit-my-profile.edit', ['admin' => $admin, 'action' => 'edit' ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\EditMyProfileStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(EditMyProfileStoreRequest $request)
    {

        // Will return only validated data
        $validatedData = $request->validated();

        $admin = Admin::findorfail( Auth::guard('admin')->user()->id );

        //if the password field was left empty
        if (empty($validatedData['password'])){
            unset($validatedData['password']);
            unset($validatedData['confirm_password']);
        } else {

            $password = $validatedData['password'];

            $validatedData['password'] = Hash::make($password);

            DB::beginTransaction();

            try {

                $userService = new UserService();
                $userService->updateAdminAsUser(Auth::guard('admin')->user()->id, $password);

                DB::commit();

            } catch (\Exception $e) {

                DB::rollback();

            }


        }

        $validatedData['contact_me'] = isset($validatedData['contact_me']) ? 'Y' : 'N';

        DB::beginTransaction();

        try {
            //updates the admin
            $save_result = $admin->update($validatedData);


            if (isset($validatedData['photo']))
            {

                if (!empty($validatedData['photo']))
                {

                    $admin->clearMediaCollection('photo');

                    $admin->addMedia(public_path( $validatedData['photo'] ))
                            ->preservingOriginal()
                            ->withCustomProperties(['folder' => $validatedData['photo'] ])
                            ->toMediaCollection('photo');

                }

            }

            DB::commit();

            return redirect()->back()->with('success','Your profile has been updated successfully');

        }
        catch (\Exception $e) {

            Log::error($e);

            DB::rollback();

            return redirect()->back()->with('error','An error occured, your profile could not be updated');
        }



    }

}
