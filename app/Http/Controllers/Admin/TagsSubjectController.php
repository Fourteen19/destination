<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubjectTagStoreRequest;

class TagsSubjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = SystemTag::where('type', 'subject')->orderBy('order_column', 'ASC')->get();

            return DataTables::of($data)
                ->addColumn('#', function($row){
                    return '<i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i>';
                })
                ->setRowAttr([
                    'data-id' => function($row) {
                        return $row->id;
                    },
                ])
                ->setRowClass(function () {
                    return 'row-item';
                })
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.tags.subjects.edit", ["subject" => $row->uuid]).'" class="edit mydir-dg btn"><i class="far fa-edit"></i></a> ';

                    if ($row->live == "Y")
                        {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-times mr-1"></i><i class="fas fa-bolt"></i></button>';
                        } else {
                            $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-check mr-1"></i><i class="fas fa-bolt"></i></button>';
                        }

                    $actions .= '<button class="open-delete-modal mydir-dg btn" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';


                    return $actions;
                })
                ->rawColumns(['#', 'action'])
                ->make(true);

        }

        return view('admin.pages.tags.subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //checks policy
        $this->authorize('create', SystemTag::class);

        $tag = new SystemTag;

        return view('admin.pages.tags.subjects.create', ['tag' => $tag]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SubjectTagStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectTagStoreRequest $request)
    {

        //calls the policy to check authoridation
        $this->authorize('create', SystemTag::class);

        DB::beginTransaction();

        try {

            $validatedData = $request->validated();

            $validatedData['type'] = 'subject';

            //creates the tag
            $tag = SystemTag::create($validatedData);

            DB::commit();

            return redirect()->route('admin.tags.subjects.index')
                            ->with('success','Subject tag created successfully');

        }
        catch (\Exception $e) {

            Log::error($e);

            DB::rollback();

            return redirect()->route('admin.tags.sectors.index')
                            ->with('error', 'An error occured, your subject tag could not be created');
        }

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Models\SystemTag  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, SystemTag $subject)
    {
        //check authoridation
        $this->authorize('update', $subject);

        return view('admin.pages.tags.subjects.edit', ['tag' => $subject]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Admin\SubjectTagStoreRequest  $request
     * @param  App\Models\SystemTag  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectTagStoreRequest $request, SystemTag $subject)
    {

        //checks policy
        $this->authorize('update', $subject);

        DB::beginTransaction();

        try {

            // Will return only validated data
            $validatedData = $request->validated();

            $validatedData['type'] = 'subject';

            //updates the tag
            $subject->update($validatedData);

            DB::commit();

            return redirect()->route('admin.tags.subjects.index')
                            ->with('success','Subject tag updated successfully');

        }
        catch (\Exception $e) {

            Log::error($e);

            DB::rollback();

            return redirect()->route('admin.tags.subjects.index')
                            ->with('error', 'An error occured, your subject tag could not be updated');
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  SystemTag  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, SystemTag $subject)
    {

        //check policy authorisation
        $this->authorize('delete', $subject);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $subjectId = $subject->id;

                $subject->delete();

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your subject tag has been successfully deleted!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your subject tag could not be deleted, Try Again!";
            }

            return response()->json($data_return, 200);

        }

    }



    /**
     * reorder
     * Reorder the records
     * Updates the records based on the 'page' and the number of 'entries' in the manage page
     *
     * @param  mixed $request
     * @return void
     */
    public function reorder(Request $request)
    {

        //check authoridation
        $this->authorize('update', SystemTag::class);

        // "page" is the page number
        // "entries" is the number of records per page
        if ( (!empty($request->input('entries'))) && ($request->has('page')) )
        {

            DB::beginTransaction();

            try {

                $page_nb = $request->input('page');
                $nb_entries = $request->input('entries');

                foreach($request->input('order', []) as $row)
                {
                    SystemTag::find($row['id'])->update([
                        'order_column' => $row['position'] + ($page_nb * $nb_entries)
                    ]);
                }

                DB::commit();

            }
            catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

            }

        }

        return response()->noContent();

    }



    /**
     * Make live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SystemTag $subject
     * @return \Illuminate\Http\Response
     */
    public function makeLive(Request $request, SystemTag $subject)
    {

        //check policy authorisation
        $this->authorize('makeLive', $subject);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $subjectId = $subject->id;

                $subject->update(['live' => 'Y']);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your subject tag has successfully been made live!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your subject tag could not be made live!";
            }

            return response()->json($data_return, 200);

        }

    }

    /**
     * remove from live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\SystemTag $subject
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Request $request, SystemTag $subject)
    {
        //check policy authorisation
        $this->authorize('makeLive', $subject);

         if ($request->ajax()) {

           DB::beginTransaction();

            try  {

                $subjectId = $subject->id;

                $subject->update(['live' => 'N']);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your subject tag has successfully been removed from live!";

            } catch (\Exception $e) {

                Log::error($e);

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your subject tag could not be removed from live!";
            }

            return response()->json($data_return, 200);

        }
    }

}
