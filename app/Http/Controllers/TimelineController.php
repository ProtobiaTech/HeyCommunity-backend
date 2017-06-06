<?php

namespace App\Http\Controllers;

use App\Events\ExtractKeywordsEvent;
use App\Events\TriggerNoticeEvent;
use Illuminate\Http\Request;

use Auth;
use App\Keyword;
use App\User;
use App\Timeline;
use App\TimelineComment;
use App\TimelineLike;

class TimelineController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postStore', 'postStoreComment', 'postSetLike']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $timelines = Timeline::latest()->paginate();
        $users     = User::limit(5)->orderByRaw('RAND()')->get();
        $keywords  = Keyword::ofType('timeline_count');

        if (request()->has('keyword')) {
            $keyword = Keyword::where('name', request()->input('keyword'))->first();
            $timelines = $keyword->timelines()->paginate();
        }

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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStoreComment(Request $request)
    {
        $this->validate($request, [
            'timeline_id'   =>      'required|integer',
            'content'       =>      'required|string',
        ]);

        $timeline = Timeline::findOrFail($request->timeline_id);
        $timelineComment = new TimelineComment();

        if ($request->timeline_comment_id) {
            $timelineComment->parent_id   =   $request->timeline_comment_id;
        }

        $timelineComment->user_id       =   Auth::user()->user()->id;
        $timelineComment->timeline_id   =   $request->timeline_id;
        $timelineComment->content       =   $request->content;

        if ($timelineComment->save()) {
            $timeline->increment('comment_num');

            if ($timelineComment->parent_id > 0) {
                if ($timelineComment->parent->user_id !== Auth::user()->user()->id) {
                    event(new TriggerNoticeEvent($timelineComment, $timelineComment->parent, 'timeline_comment_comment'));
                }
            } else {
                if ($timeline->user_id !== Auth::user()->user()->id) {
                    event(new TriggerNoticeEvent($timelineComment, $timeline, 'timeline_comment'));
                }
            }

            return back();
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
    public function getShow($id)
    {
        $timeline = Timeline::with('keywords')->findOrFail($id);
        $users = User::limit(5)->orderByRaw('RAND()')->get();
        $comments = $timeline->comments()->paginate();

        return view('timeline.show', compact('timeline', 'users', 'comments'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetLike(Request $request)
    {
        $this->validate($request, [
           'id' => 'required|numeric',
        ]);

        $TimelineLike = TimelineLike::where(['timeline_id' => $request->id, 'user_id' => Auth::user()->user()->id])->first();
        $Timeline = Timeline::findOrFail($request->id);

        if ($TimelineLike) {
            $TimelineLike->forceDelete();
            $Timeline->decrement('like_num');
        } else {
            $TimelineLike = new TimelineLike;
            $TimelineLike->user_id = Auth::user()->user()->id;
            $TimelineLike->timeline_id = $request->id;
            $TimelineLike->save();
            $Timeline->increment('like_num');

            if ($Timeline->user_id !== Auth::user()->user()->id) {
                event(new TriggerNoticeEvent($TimelineLike, $Timeline, 'timeline_like'));
            }

        }

        return back();

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
