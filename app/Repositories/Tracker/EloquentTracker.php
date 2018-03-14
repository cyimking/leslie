<?php

namespace Leslie\Repositories\Tracker;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tracker;

class EloquentTracker implements TrackerRepository
{

    /**
     * {@inheritdoc}
     */
    public function getVisitors()
    {
        $visitors = Tracker::sessions(60 * 24);

        return $visitors;
    }

    /**
     * {@inheritdoc}
     */
    public function getPathsByVisitorID($visitorID)
    {
        $logs = DB::table('tracker_log')
            ->leftJoin('tracker_paths', 'tracker_log.path_id', '=', 'tracker_paths.id')
            ->select('tracker_paths.*', 'tracker_log.*')
            ->where('tracker_log.session_id', '=', $visitorID)
            ->orderBy('tracker_log.id', 'desc')
            ->paginate(10);

        return $logs;
    }
}