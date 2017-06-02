<?php

namespace App\Http\Controllers;

use App\Timeline;
use App\Topic;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        return view('ucenter.notice');
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
