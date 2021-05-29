<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Admin\EventService;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{

    private $eventService;


    public function __construct(EventService $eventService)
    {

        $this->eventService = $eventService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         //check authoridation
        $this->authorize('list', Event::class);

        if (!$request->ajax()) {


        //if AJAX request
        } else {

            $items = DB::table('events')
            ->leftjoin('events_live', 'events.id', '=', 'events_live.id')
            ->where('events.deleted_at', NULL)
            ->orderBy('events.updated_at','DESC')
            ->select(
                "events.uuid",
                "events.title",
                DB::raw("DATE_FORMAT(events.date, '%d/%m/%Y') as formatted_date"),
                "events.updated_at",
                "events.deleted_at",
                "events_live.deleted_at as deleted_at_live",
                "events.id as live_id",
                "events.updated_at as live_updated_at"
            );

            return DataTables::of($items)
            ->addColumn('title', function($row){
                return $row->title;
            })
            ->addColumn('date', function($row){
                return $row->formatted_date;
            })
            ->addColumn('client', function($row){
                return "[CLIENT]";
            })
            ->addColumn('institution', function($row){
                return "[INSTITUTION]";
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('event-edit') ){
                    $actions = '<a href="'.route("admin.events.edit", ['event' => $row->uuid]).'" class="edit mydir-dg btn">Edit</a> ';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('event-make-live') ) && ( (empty($row->live_id)) || ( (!empty($row->live_id) && (!empty($row->deleted_at_live)) ) ) ) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Make Live</button>';
                } elseif ( (Auth::guard('admin')->user()->hasAnyPermission('event-make-live') ) && (!empty($row->live_id)) && ($row->updated_at != $row->live_updated_at) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-apply-latest-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Apply latest changes to Live</button>';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('event-make-live') ) && (!empty($row->live_id)) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Remove from Live</button>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('event-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'">Delete</button>';
                }

                return $actions;
            })
            ->rawColumns(['action'])
            ->make(true);

        }

        return view('admin.pages.events.index', ['contentOwner' => app('clientService')->getClientNameForAdminPages() ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //check authoridation
        $this->authorize('create', Event::class);

        $event = new Event;

        return view('admin.pages.events.create', ['event' => $event,
                                                 'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }

    public function edit(Event $event)
    {

        //check authoridation
        $this->authorize('update', $event);

        return view('admin.pages.events.edit', ['event' => $event,
                                                    'contentOwner' => app('clientService')->getClientNameForAdminPages() ]);
    }



    /**
     * Make live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ContenEventt $event
     * @return \Illuminate\Http\Response
     */
    public function makeLive(Request $request, Event $event)
    {

        //check policy authorisation
        $this->authorize('makeLive', $event);

        if ($request->ajax()) {

            /* DB::beginTransaction();

            try  {
 */
                $event_id = $event->id;

                $this->eventService->makeLive($event);

                /* DB::commit(); */

                $data_return['result'] = true;
                $data_return['message'] = "Your event has successfully been made live!";

            /* } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your event could not be made live!";
            } */

            return response()->json($data_return, 200);

        }

    }



    /**
     * remove from live the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Event $event
     * @return \Illuminate\Http\Response
     */
    public function removeLive(Request $request, Event $event)
    {
        //check policy authorisation
        $this->authorize('makeLive', $event);

         if ($request->ajax()) {

            /* DB::beginTransaction();

            try  { */

                $event_id = $event->id;

                $this->eventService->removeLive($event);

                /* DB::commit(); */

                $data_return['result'] = true;
                $data_return['message'] = "Your event has successfully been removed from live!";

            /* } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your event could not be removed from live!";
            } */

            return response()->json($data_return, 200);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  mixed $resource
     * @return void
     */
    public function destroy(Request $request, Event $event, EventService $eventService)
    {
        //check policy authorisation
        $this->authorize('delete', $event);

        if ($request->ajax()) {

            DB::beginTransaction();

            try  {

                $eventId = $event->id;

                $result = $eventService->delete($event);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Event successfully deleted!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Event could not be not deleted, Try Again!";

            }

            return response()->json($data_return, 200);

        }
    }
}
