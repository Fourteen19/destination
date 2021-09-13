<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use App\Models\Admin\Admin;
use App\Models\Institution;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use \Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\InstitutionService;
use App\Http\Requests\Admin\InstitutionStoreRequest;
use App\Http\Requests\Admin\InstitutionAdvisorStoreRequest;

class ClientInstitutionAdviserController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Client $client, Institution $institution)
    {

        //check authoridation
        $this->authorize('update', $institution);

        $institutionId = $institution->id;

        //select advisors for the institution
        //use the institutions relationship , filtered by institution && select data from pivot table
        $advisors = Admin::adminTypeFromInstitution( config('global.admin_user_type.Advisor'), $institutionId )
                ->select('id', 'uuid', 'title', 'first_name', 'last_name', 'email')
                ->with(['institutions' => function ($q) use ($institutionId) {
                    $q->where('institution_id', $institutionId);
                    $q->withPivot('introduction','times_location');
                }])
                ->get();

        return view('admin.pages.institutions-advisers.edit', ['client' => $client, 'institution' => $institution, 'advisors' => $advisors]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\InstitutionStoreRequest  $request
     * @param  \App\Models\Client $client
     * @param  \App\Models\Institution $institution
     * @return \Illuminate\Http\Response
     */
    public function update(InstitutionAdvisorStoreRequest $request, Client $client, Institution $institution)
    {

        //check authoridation
        $this->authorize('update', $institution);

        // Will return only validated data
        $validatedData = $request->validated();

        DB::beginTransaction();

        try {


            $advisors = Admin::adminTypeFromInstitution( config('global.admin_user_type.Advisor'), $institution->id )
                ->select('id', 'uuid', 'title', 'first_name', 'last_name', 'email')
                ->get();

            //foreach advisor
            foreach($advisors as $advisor)
            {

                //gets the pivot table data for a specific institution
                $institution = $advisor->relatedInstitutionData($institution->id)->first();

                $institution->pivot->introduction = $validatedData['introduction'][$advisor->uuid];
                $institution->pivot->times_location = $validatedData['times_location'][$advisor->uuid];
                $institution->pivot->update();

            }

            DB::commit();

             return redirect()->route('admin.clients.institutions.index', ['client' => $client, 'institution' => $institution])
                             ->with('success', 'Adviser information updated successfully');

         }
        catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.clients.institutions.index', ['client' => $client, 'institution' => $institution])
                            ->with('error', 'An error occured, your adviser information could not be updated');
        }

    }



}
