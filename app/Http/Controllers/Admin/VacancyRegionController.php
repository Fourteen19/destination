<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\VacancyRegion;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Admin\VacancyRegionService;
use App\Http\Requests\Admin\VacancyRegionStoreRequest;

class VacancyRegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', VacancyRegion::class);

        if (!$request->ajax()) {


        //if AJAX request
         } else {

            //compiles the query
            $items = VacancyRegion::select('uuid', 'name', 'display')
                                    ->where('deleted_at', '=', NULL)
                                    ->orderBy('name', 'ASC');


            return DataTables::of($items)
            ->addColumn('name', function($row){
                return $row->name;
            })
            ->addColumn('display', function($row){
                return $row->display;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-region-edit') ){
                    $actions = '<a href="'.route("admin.vacancies.regions.edit", ['region' => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('vacancy-region-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                }

                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.vacancies.regions.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //check authoridation
        $this->authorize('create', VacancyRegion::class);

        $vacancyRegion = new VacancyRegion;

        return view('admin.pages.vacancies.regions.create', ['vacancyRegion' => $vacancyRegion,
                                                             'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }

    /**
     * Store a newly created vacancy in storage.
     *
     * @param  mixed $request
     * @param  mixed $vacancyService
     * @return void
     */
    public function store(VacancyRegionStoreRequest $request, VacancyRegionService $vacancyRegionService)
    {
        //checks policy
        $this->authorize('create', VacancyRegion::class);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the resource
            $vacancyRegionService->createVacancyRegion($validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.regions.index')
                ->with('success','Your vacancy region has been created successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.vacancies.regions.index')
                            ->with('error', 'An error occured, your vacancy region could not be created');
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  VacancyRegion $vacancyRegion
     * @return \Illuminate\Http\Response
     */
    public function edit(VacancyRegion $region)
    {

        //check authoridation
        $this->authorize('update', $region);

        return view('admin.pages.vacancies.regions.edit', ['vacancyRegion' => $region]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  mixed $request
     * @param  mixed $resource
     * @return void
     */
    public function update(VacancyRegionStoreRequest $request, VacancyRegion $region, VacancyRegionService $vacancyRegionService)
    {

        //checks policy
        $this->authorize('update', $region);

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

            //creates the vacancy
            $vacancyRegionService->updateVacancyRegion($region, $validatedData);

            DB::commit();

            return redirect()->route('admin.vacancies.regions.index')
                ->with('success','Your vacancy region has been updated successfully');

        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->route('admin.vacancies.regions.index')
                            ->with('error', 'An error occured, your vacancy region could not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $resource
     * @return void
     */
    public function destroy(Request $request, VacancyRegion $region, VacancyRegionService $vacancyRegionService)
    {
        //check policy authorisation
        $this->authorize('delete', $region);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $vacancyRegionId = $region->id;

                $region->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Vacancy region successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Vacancy region could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }

}
