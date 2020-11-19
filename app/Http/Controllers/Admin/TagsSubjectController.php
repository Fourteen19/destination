<?php

namespace App\Http\Controllers\Admin;

use App\Models\SystemTag;
use Illuminate\Http\Request;
use \Yajra\DataTables\DataTables;
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

            $data = SystemTag::where('type', 'subject')->get();

            return DataTables::of($data)
                ->addColumn('name', function($row){
                    return $row->name;
                })
                ->addColumn('action', function($row){

                    $actions = '<a href="'.route("admin.tags.subjects.edit", ["subject" => $row->id]).'" class="edit btn btn-primary btn-sm">Edit</a> ';

                    $live_buttton_txt = "";
                    if ($row->live == "Y")
                    {
                        $live_buttton_txt = "Make Not Live";
                    } else {
                        $live_buttton_txt = "Make Live";
                    }
                    $actions .= '<a href="#" class="edit btn btn-primary btn-sm">'.$live_buttton_txt.'</a> ';

                    $actions .= '<button class="open-delete-modal btn btn-danger" data-id="'.$row->id.'">Delete</button>';


                    return $actions;
                })
                ->rawColumns(['action'])
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
        $validatedData = $request->validated();

        $validatedData['type'] = 'subject';

        //creates the tag
        $tag = SystemTag::create($validatedData);

        return redirect()->route('admin.tags.subjects.index')
                         ->with('success','Subject tag created successfully');
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
        //calls the Adminpolicy update function to check authoridation
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
        // Will return only validated data
        $validatedData = $request->validated();

        $validatedData['type'] = 'subject';

        //updates the tag
        $subject->update($validatedData);

        return redirect()->route('admin.tags.subjects.index')
                         ->with('success','Subject tag updated successfully');
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
