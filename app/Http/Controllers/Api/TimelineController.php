<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeline;
use App\TimelineLike;
use App\TimelineComment;
use App\Notice;
use Auth;

class TimelineController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postStore', 'postSetLike', 'postDestroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $query = Timeline::with(['author', 'author_like', 'comments'])
            ->orderBy('id', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10);

        if ($request->type === 'refresh') {
            $query->where('id', '>', $request->id);
        } else if ($request->type === 'infinite') {
            $query->where('id', '<', $request->id);
        }

        $timelines = $query->get()->each(function($item, $key) {
            $item->is_like = TimelineLike::where(['timeline_id' => $item->id, 'user_id' => 1])->count() ? true : false;
        })->toArray();

        return $timelines;
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
            'content'       =>      'required_without:attachment',
            'attachment'    =>      'required_without:content',
        ]);

        $Timeline = new Timeline;

        // have attachment
        if ($request->attachment) {
            $file = $request->file('attachment');
            $uploadPath = '/uploads/timeline/';
            $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . $uploadPath, $fileName);

            $Timeline->attachment   =       $uploadPath . $fileName;
        }

        // have content
        if ($request->content) {
            $Timeline->content      =       $request->content;
        }

        $Timeline->user_id      =       Auth::user()->id;
        $Timeline->save();
        return Timeline::with(['author', 'comments', 'author_like'])->findOrFail($Timeline->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id)
    {
        return Timeline::with(['author', 'comments', 'author_like'])->findOrFail($id);
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
    public function postDestroy(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Timeline = Timeline::findOrFail($request->id);

        if ($Timeline->user_id === Auth::user()->id) {
            return $Timeline->delete() ? ['success'] : response('fail', 500);
        } elseif (Auth::user()->id === Auth::user()->id) {
            return $Timeline->delete() ? ['success'] : response('fail', 500);
        }

        return abort(403, 'Insufficient permissions');
    }

    /**
     * set timeline is like
     *
     * @return
     */
    public function postSetLike(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $TimelineLike = TimelineLike::where(['timeline_id' => $request->id, 'user_id' => Auth::user()->id])->first();
        $Timeline = Timeline::findOrFail($request->id);

        if ($TimelineLike) {
            $TimelineLike->delete();
            $Timeline->decrement('like_num');
        } else {
            $TimelineLike = new TimelineLike;
            $TimelineLike->user_id      =       Auth::user()->id;
            $TimelineLike->timeline_id  =       $request->id;
            $TimelineLike->save();
            $Timeline->increment('like_num');

            // notice
            /*
            $Notice = new Notice;
            $Notice->user_id            =       $Timeline->user_id;
            $Notice->initiator_user_id  =       1;
            $Notice->type_id            =       10;     // timeline_like
            $Notice->noticeable_id      =       $Timeline->id;
            $Notice->noticeable_type    =       Timeline::class;
            $Notice->save();
             */
        }

        $Timeline = $Timeline->with(['author', 'author_like', 'comments'])->findOrFail($request->id);
        $Timeline->is_like = TimelineLike::where(['timeline_id' => $Timeline->id, 'user_id' => 1])->count() ? true : false;
        return $Timeline;
    }

    /**
     *
     */
    public function postCommentPublish(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
            'content'   =>      'required',
        ]);

        $Timeline = Timeline::findOrFail($request->id);
        $TimelineComment = new TimelineComment;

        $TimelineComment->timeline_id   =   $request->id;
        $TimelineComment->user_id       =   Auth::user()->id;
        $TimelineComment->content       =   $request->content;
        $TimelineComment->save();
        $Timeline->increment('comment_num');

        // notice
        $Notice = new Notice;
        $Notice->user_id            =       $Timeline->user_id;
        $Notice->initiator_user_id  =       Auth::user()->id;
        $Notice->type_id            =       11;     // timeline_comment
        $Notice->noticeable_id      =       $Timeline->id;
        $Notice->noticeable_type    =       Timeline::class;
        $Notice->save();

        return $Timeline->with(['author', 'author_like', 'comments'])->findOrFail($request->id);
    }
}
