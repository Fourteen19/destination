<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        return view('admin.pages.edit-my-profile.edit', ['admin' => $admin ]);

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
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $validatedData['contact_me'] = isset($validatedData['contact_me']) ? 'Y' : 'N';

        DB::beginTransaction();

        try{
            //updates the admin
            $save_result = $admin->update($validatedData);

            DB::commit();

            return redirect()->back()->with('success','Your profile has been updated successfully');

        }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error','An error occured, your profile could not be updated');
        }



    }

}
