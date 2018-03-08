<?php

namespace Leslie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tracker;

class TrackerController extends Controller
{
    /**
     * Retrieve traffic from the last 24 hours.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function visitors(Request $request)
    {
        $sessions = Tracker::sessions(60 * 24);

        return $request->isJson() ? response()->json($sessions) : view('layouts.app');
    }

    /**
     *
     *
     * @param $sessionId
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function visitorsBySessionId($sessionId, Request $request)
    {
        $logs = DB::table('tracker_log')
                    ->leftJoin('tracker_paths', 'tracker_log.path_id', '=', 'tracker_paths.id')
                    ->where('tracker_log.session_id', '=', $sessionId)
                    ->get();

        return $request->isJson() ? response()->json($logs) : view('layouts.app');
    }
}
