<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PageLive;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Services\Admin\PageService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Scopes\Admin\BelongsToClientScope;

class PageController extends Controller
{


    protected $pageService;

    public function __construct(PageService $pageService)
    {

        $this->pageService = $pageService;

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //check authoridation
        $this->authorize('list', Page::class);

        if (!$request->ajax()) {

            if (isGlobalAdmin()){

                //check if the route is global or client
                $contentOwner = (Route::is('admin.global*')) ? "Global" : Session::get('client')['name'] ;
                if (Route::is('admin.global*')){
                    $contentOwner = "Global";
                } else {

                    //determine if present in the session and is not null
                    if ( Session::has('adminClientSelectorSelection') )
                    {
                        $contentOwner = Session::get('all_clients')[ Session::get('adminClientSelectorSelection') ];
                    } else {
                        $contentOwner = "Undefined";
                    }

                }

            } else {
                $contentOwner = Session::get('adminClientName');

            }


        //if AJAX request
        } else {

            $items = DB::table('pages')
            ->leftjoin('pages_live', 'pages.id', '=', 'pages_live.id')
            ->join('page_templates', 'pages.template_id', '=', 'page_templates.id')
            ->join('clients', 'clients.id', '=', 'pages.client_id')
            ->where('pages.deleted_at', NULL)
            ->where('pages.pageable_type', '!=','App\Models\PageHomepage')
            ->orderBy('pages.order_id', 'ASC')
            ->select(
                "pages.id",
                "pages.uuid",
                "pages.title",
                "pages.updated_at",
                "pages_live.id as live_id",
                "pages_live.updated_at as live_updated_at",
                "page_templates.slug",
                "page_templates.slug_plural"
            );


            if (isGlobalAdmin())
            {
                $items = $items->where('clients.uuid', '=', Session::get('adminClientSelectorSelection') );
            } elseif (isclientAdmin()) {
                $items = $items->where('pages.client_id', '=', Auth::guard('admin')->user()->client_id);
            }


            return DataTables::of($items)
                ->addColumn('#', function($row){
                    return '<i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i>';
                })
                ->setRowAttr([
                    'data-uuid' => function($row) {
                        return $row->uuid;
                    },
                ])
                ->setRowClass(function () {
                    return 'row-item';
                })
                ->addColumn('name', function($row){
                    return $row->title;
                })
                ->addColumn('action', function($row){

                    $actions = "";

                    if (Auth::guard('admin')->user()->hasAnyPermission('page-edit') ){
                        $actions .= '<a href="'.route("admin.pages.".$row->slug.".edit", [$row->slug => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                    }

                    //if the user has the permission to make content live
                    if ( Auth::guard('admin')->user()->hasAnyPermission('page-make-live') )
                    {

                        //if the content is NOT live OR if both updated date are not the same
                        if ( (empty($row->live_id)) || ($row->updated_at != $row->live_updated_at) )
                        {
                            $class = "open-make-live-modal";
                            $label = "Make Live";

                        //elseif the content is live
                        } else {
                            $class = "open-remove-live-modal";
                            $label = "Remove from Live";
                        }
                        $actions .= '<button id="live_'.$row->uuid.'" class="'.$class.' open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">'.$label.'</button>';
                    }

                    //if the user has the permission to delete content
                    if ( Auth::guard('admin')->user()->hasAnyPermission('page-delete') )
                    {
                        $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                    }

                    return $actions;
                })

                ->rawColumns(['#','action'])
                ->make(true);

        }

        return view('admin.pages.pages.index', ['contentOwner' => $contentOwner ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Content $content
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Page $page)
    {

        //check policy authorisation
        $this->authorize('delete', $page);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $pageId = $page->id;

                $result = $this->pageService->delete($page);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Page successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Page could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }

    }



    /**
     * Make live the specified resource from storage.
     *
     * @param  mixed $request
     * @param  mixed $page
     * @return void
     */
    public function makeLive(Request $request, Page $page)
    {

        //check policy authorisation
        $this->authorize('makeLive', $page);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $result = $this->pageService->makeLive($page);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your page has successfully been made live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Page could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }

    }



    /**
     * remove from live the specified resource from storage.
     *
     * @param  mixed $request
     * @param  mixed $page
     * @return void
     */
    public function removeLive(Request $request, Page $page)
    {
        //check policy authorisation
        $this->authorize('makeLive', $page);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $result = $this->pageService->removeLive($page);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your page has successfully been removed from live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your page coule not be removed from live!";

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
        $this->authorize('reorder', Page::class);

        // "page" is the page number
        // "entries" is the number of records per page
        if ( (!empty($request->input('entries'))) && ($request->has('page')) )
        {

            $page_nb = $request->input('page');
            $nb_entries = $request->input('entries');

            DB::beginTransaction();

            try {

                foreach($request->input('order', []) as $row)
                {

                    Page::where('uuid', $row['uuid'])->update([
                        'order_id' => $row['position'] + ($page_nb * $nb_entries)
                    ]);

                    PageLive::where('uuid', $row['uuid'])->update([
                        'order_id' => $row['position'] + ($page_nb * $nb_entries)
                    ]);
                }

                DB::commit();

            }
            catch (\Exception $e) {

                DB::rollback();

            }

        }

        return response()->noContent();

    }


}
