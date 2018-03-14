<?php

namespace Leslie\Repositories\Tracker;

interface TrackerRepository
{
    /**
     * Retrieve sessions
     *
     * @return mixed
     */
    public function getVisitors();

    /**
     * Retrieve paths from given session ID
     *
     * @param $visitorID
     * @return mixed
     */
    public function getPathsByVisitorID($visitorID);
}