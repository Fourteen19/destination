<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\SystemKeywordTag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportKeywordsDataController extends Controller
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


    public function index(Request $request)
    {

        if (!Auth::guard('admin')->user()->hasPermissionTo('report-list')) {
            abort(403);
        }
/*
         $institutionId = 3;
        $year = 1;
        $clientId = 1;
        $ee = SystemKeywordTag::query()
        ->where('id', 93)->where('type', 'keyword')
                                         ->where('client_id', $clientId)
                                         ->where('live', 'Y')
                                         ->with('keywordsTagsTotalStats', function ($query) use ($institutionId, $year) {
                                             $query->select('tag_id', 'total', 'year_7', 'year_8', 'year_9', 'year_10', 'year_11', 'year_12', 'year_13', 'year_14')
                                                ->where('year_id', $year)
                                                ->where('institution_id', $institutionId);

                                         })
                                         ->orderBy('name', 'asc')->get();

    foreach($ee as $k => $tag)
    {

        $stats = $tag->keywordsTagsTotalStats;

        if (!$stats)
        {
            $statsData = ['0', '0', '0', '0', '0', '0', '0', '0', '0'];
        } else {

$stats = $stats->first();
//dd($stats);
            if (isset($stats->total))
            {

                $statsData = [
                    ($stats->total == 0) ? '0' : $stats->total,
                    ($stats->year_7 == 0) ? '0' : $stats->year_7,
                    ($stats->year_8 == 0) ? '0' : $stats->year_8,
                    ($stats->year_9 == 0) ? '0' : $stats->year_9,
                    ($stats->year_10 == 0) ? '0' : $stats->year_10,
                    ($stats->year_11 == 0) ? '0' : $stats->year_11,
                    ($stats->year_12 == 0) ? '0' : $stats->year_12,
                    ($stats->year_13 == 0) ? '0' : $stats->year_13,
                    ($stats->year_14 == 0) ? '0' : $stats->year_14,
                ];
            } else {
                $statsData = ['0', '0', '0', '0', '0', '0', '0', '0', '0'];
            }
        }

    }

dd($statsData); */

        return view('admin.pages.reports.keywords.show');

    }

}

