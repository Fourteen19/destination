<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
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


            //if system admin, load all the events
            if (isGlobalAdmin())
            {

                $items = DB::table('events')
                ->leftjoin('events_live', 'events.id', '=', 'events_live.id')
                ->leftjoin('clients', 'clients.id', '=', 'events.client_id')
                ->where('events.deleted_at', NULL)
                ->whereDate('events.date', '>=', Carbon::today()->toDateString())
                ->select(
                    "events.id",
                    "events.uuid",
                    "events.title",
                    "events.client_id",
                    "events.institution_specific",
                    DB::raw("DATE_FORMAT(events.date, '%d/%m/%Y') as formatted_date"),
                    "events.updated_at",
                    "events.deleted_at",
                    "events_live.deleted_at as deleted_at_live",
                    "events_live.id as live_id",
                    "events_live.updated_at as live_updated_at",
                    "clients.name as client_name"
                )
                ->orderBy('events.date');

            } elseif ( adminHasAnyRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Client_Admin'), config('global.admin_user_type.Client_Content_Admin'), ]) ) {

                $items = DB::table('events')
                ->leftjoin('events_live', 'events.id', '=', 'events_live.id')
                ->leftjoin('clients', 'clients.id', '=', 'events.client_id')
                ->where('events.deleted_at', NULL)
                ->where('events.client_id', Auth::guard('admin')->user()->client_id)
                ->whereDate('events.date', '>=', Carbon::today()->toDateString())
                ->select(
                    "events.id",
                    "events.uuid",
                    "events.title",
                    "events.client_id",
                    "events.institution_specific",
                    DB::raw("DATE_FORMAT(events.date, '%d/%m/%Y') as formatted_date"),
                    "events.updated_at",
                    "events.deleted_at",
                    "events_live.deleted_at as deleted_at_live",
                    "events_live.id as live_id",
                    "events_live.updated_at as live_updated_at",
                    "clients.name as client_name"
                )
                ->orderBy('events.date');

            //} elseif ( (isClientAdvisor()) || (isClientTeacher()) ) {
            } elseif ( adminHasAnyRole(Auth::guard('admin')->user(), [config('global.admin_user_type.Third_Party_Admin'),
                                                                        config('global.admin_user_type.Teacher'),
                                                                        config('global.admin_user_type.Advisor'),
                                                                    ]) ) {

                $items = DB::table('events')
                ->leftjoin('events_live', 'events.id', '=', 'events_live.id')
                ->leftjoin('clients', 'clients.id', '=', 'events.client_id')
                ->where('events.deleted_at', NULL)
                ->where('events.client_id', Auth::guard('admin')->user()->client_id)
                ->where('events.created_by', Auth::guard('admin')->user()->id)
                ->whereDate('events.date', '>=', Carbon::today()->toDateString())
                ->select(
                    "events.id",
                    "events.uuid",
                    "events.title",
                    "events.client_id",
                    "events.institution_specific",
                    DB::raw("DATE_FORMAT(events.date, '%d/%m/%Y') as formatted_date"),
                    "events.date as formatted_date ",
                    "events.updated_at",
                    "events.deleted_at",
                    "events_live.deleted_at as deleted_at_live",
                    "events_live.id as live_id",
                    "events_live.updated_at as live_updated_at",
                    "clients.name as client_name"
                )
                ->orderBy('events.date');

            }



            return DataTables::of($items)
            ->addColumn('title', function($row){
                return $row->title;
            })
            ->editColumn('date', function ($row) {
                return [
                   'display' => $row->formatted_date,
                   'timestamp' => strtotime(str_replace('/', '-', $row->formatted_date))
                ];
            })
            ->addColumn('client', function($row){
                $client_name_txt = "";
                if (is_null($row->client_id))
                {
                    $client_name_txt = "ALL";
                } else {
                    $client_name_txt = $row->client_name;
                }
                return $client_name_txt;
            })
            ->addColumn('institution', function($row){
                $institutions_txt = "";
                if ($row->institution_specific == 'Y')
                {
                    $institutions = Event::find($row->id)->institutions()->get();
                    foreach($institutions as $institution)
                    {
                        $institutions_txt .= $institution->name . "<br>";
                    }

                } else {
                    $institutions_txt = "ALL";
                }
                return $institutions_txt;
            })
            ->addColumn('action', function($row){

                $actions = "";

                if (Auth::guard('admin')->user()->hasAnyPermission('event-edit') ){
                    $actions = '<a href="'.route("admin.events.edit", ['event' => $row->uuid]).'" class="edit mydir-dg btn"><i class="far fa-edit"></i></a> ';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('event-make-live') ) && ( (empty($row->live_id)) || ( (!empty($row->live_id) && (!empty($row->deleted_at_live)) ) ) ) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-make-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-check mr-1"></i><i class="fas fa-bolt"></i></button>';
                } elseif ( (Auth::guard('admin')->user()->hasAnyPermission('event-make-live') ) && (!empty($row->live_id)) && ($row->updated_at != $row->live_updated_at) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-apply-latest-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-clock mr-1"></i><i class="fas fa-bolt"></i></button>';
                }

                if ( (Auth::guard('admin')->user()->hasAnyPermission('event-make-live') ) && (!empty($row->live_id)) && (empty($row->deleted_at_live)) )
                {
                    $actions .= '<button id="live_'.$row->uuid.'" class="open-remove-live-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="fas fa-times mr-1"></i><i class="fas fa-bolt"></i></button>';
                }

                if (Auth::guard('admin')->user()->hasAnyPermission('event-delete') ){
                    $actions .= '<button class="open-delete-modal mydir-dg btn mx-1" data-id="'.$row->uuid.'"><i class="far fa-trash-alt"></i></button>';
                }

                return $actions;
            })
            ->filter(function ($query){

                if (request()->has('search.value')) {
                    if (!empty(request('search.value'))){
                        $query->where('events.title', 'LIKE', "%" . request('search.value') . "%");
                    }
                }

            })
            ->rawColumns(['action', 'institution'])
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

            DB::beginTransaction();

            try  {

                $event_id = $event->id;

                $this->eventService->makeLive($event);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your event has successfully been made live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your event could not be made live!";
            }

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

            DB::beginTransaction();

            try  {

                $event_id = $event->id;

                $this->eventService->removeLive($event);

                DB::commit();

                $data_return['result'] = true;
                $data_return['message'] = "Your event has successfully been removed from live!";

            } catch (\Exception $e) {

                DB::rollback();

                $data_return['result'] = false;
                $data_return['message'] = "Your event could not be removed from live!";
            }

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
