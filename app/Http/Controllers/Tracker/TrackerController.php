<?php
//TODO - CREATE REPO FOR THIS CLASS
namespace Leslie\Http\Controllers\Tracker;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Leslie\Http\Controllers\Controller;
use Leslie\Repositories\Tracker\TrackerRepository;

class TrackerController extends Controller
{
    /**
     * @var TrackerRepository
     */
    private $tracker;

    /**
     * TrackerController constructor.
     *
     * @param TrackerRepository $trackerRepository
     */
    public function __construct(TrackerRepository $trackerRepository)
    {
        $this->tracker = $trackerRepository;
    }

    /**
     * Retrieve traffic from the last 24 hours.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function visitors(Request $request)
    {
        $sessions = $this->tracker->getVisitors();

        return $request->isJson() ? response()->json($sessions) : view('layouts.app');
    }

    /**
     * Retrieve paths for session ID
     *
     * @param $visitorID
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function visitorsBySessionId($visitorID, Request $request)
    {
        $logs = $this->tracker->getPathsByVisitorID($visitorID);

        return $request->isJson() ? response()->json($logs) : view('layouts.app');
    }
}