<?php

namespace App\Http\Controllers;

use App\Events\ExtractKeywordsEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Keyword;
use App\User;
use App\Timeline;
use App\TimelineComment;

class TimelineController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postStore']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $timelines = Timeline::latest()->paginate();
        $users = User::limit(5)->orderByRaw('RAND()')->get();
        $keywords = Keyword::latest('timeline_count')->take(8)->get();

        return view('timeline.index', compact('timelines', 'users', 'keywords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $this->validate($request, [
            'content'     =>      'required|string',
        ]);

        $timeline = new Timeline();
        $timeline->user_id = Auth::user()->user()->id;
        $timeline->content = $request->content;

        if ($timeline->save()) {
            event(new ExtractKeywordsEvent($timeline));

            return redirect()->to('/timeline');
        } else {
            return back();
        }
    }

    /**
     * Store Comment
     */
    public function postStoreComment(Request $request)
    {
        $this->validate($request, [
            'timeline_id'   =>      'required|integer',
            'content'       =>      'required|string',
        ]);

        $timelineComment = new TimelineComment();
        $timelineComment->user_id       =   Auth::user()->user()->id;
        $timelineComment->timeline_id   =   $request->timeline_id;
        $timelineComment->content       =   $request->content;

        if ($timelineComment->save()) {
            return redirect()->to('/timeline');
        } else {
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
