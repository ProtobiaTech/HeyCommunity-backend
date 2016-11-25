<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeline;

class TimelineController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $assign['timelines'] = Timeline::orderBy('id', 'desc')->paginate();
        return view('dashboard.timeline.index', $assign);
    }
}
