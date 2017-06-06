<?php

namespace App\Http\Controllers;

use Auth;
use App\Notice;
use App\Timeline;
use App\Topic;

class UserCenterController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return redirect()->to('/ucenter/notice');
    }

    /**
     * Notice page
     */
    public function getNotice()
    {
        $notices = Notice::with(['initiator', 'type', 'entity', 'target'])->where('user_id', Auth::user()->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate();

        return view('ucenter.notice', compact('notices'));
    }

    /**
     * Timeline page
     */
    public function getTimeline()
    {
        $timelines = Timeline::latest()->with('author', 'comments')->where('user_id', \Auth::user()->user()->id)->paginate();

        return view('ucenter.timeline', compact('timelines'));
    }

    /**
     * Topic page
     */
    public function getTopic()
    {
        $topics = Topic::latest()->with('author')->where('user_id', \Auth::user()->user()->id)->paginate();

        return view('ucenter.topic', compact('topics'));
    }

}
