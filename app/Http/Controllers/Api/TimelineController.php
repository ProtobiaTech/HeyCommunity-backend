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
        $this->middleware('auth.user', ['only' => ['postStore', 'postLike', 'postDestroy']]);
        $this->middleware('auth.userAdmin', ['only' => ['postDestroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        if ($request->where) {
            // uhome api
            $ret['timelines'] = Timeline::with(['author', 'author_like', 'comments'])->where($request->where['key'], $request->where['value'])->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10)->toArray();
        } else if ($request->type) {
            if ($request->type === 'refresh') {
                $ret['timelines'] = Timeline::with(['author', 'author_like', 'comments'])
                    ->where('id', '>', $request->id)
                    ->orderBy('created_at', 'asc')->orderBy('id', 'asc')->limit(10)->get()->toArray();
            } else if ($request->type === 'infinite') {
                $ret['timelines'] = Timeline::with(['author', 'author_like', 'comments'])
                    ->where('id', '<', $request->id)
                    ->orderBy('created_at', 'desc')->orderBy('id', 'desc')->limit(10)->get()->toArray();
            }
        } else {
            $ret['timelines'] = Timeline::with(['author', 'author_like', 'comments'])->orderBy('created_at', 'desc')->orderBy('id', 'desc')->limit(10)->get()->toArray();
        }

        // likes
        if (Auth::user()->check()) {
            $ret['likes'] = TimelineLike::where('user_id', Auth::user()->user()->id)->get()->lists('timeline_id');
        } else {
            $ret['likes'] = [];
        }
        return $ret;
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
            'content'       =>      'required',
            'attachment'    =>      'required',
        ]);

        $file = $request->file('attachment');
        $uploadPath = '/uploads/timeline/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move(public_path() . $uploadPath, $fileName);

        $Timeline = new Timeline;
        $Timeline->user_id      =       Auth::user()->user()->id;
        $Timeline->content      =       $request->content;
        $Timeline->attachment   =       $uploadPath . $fileName;
        $Timeline->save();
        return $Timeline;
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

        return Timeline::destroy($request->id);
    }

    /**
     *
     */
    public function postLike(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $TimelineLike = TimelineLike::where(['timeline_id' => $request->id, 'user_id' => Auth::user()->user()->id])->first();
        $Timeline = Timeline::findOrFail($request->id);

        if ($TimelineLike) {
            $TimelineLike->delete();
            $Timeline->decrement('like_num');
        } else {
            $TimelineLike = new TimelineLike;
            $TimelineLike->user_id      =       Auth::user()->user()->id;
            $TimelineLike->timeline_id  =       $request->id;
            $TimelineLike->save();
            $Timeline->increment('like_num');

            // notice
            $Notice = new Notice;
            $Notice->user_id            =       $Timeline->user_id;
            $Notice->initiator_user_id  =       Auth::user()->user()->id;
            $Notice->type_id            =       10;     // timeline_like
            $Notice->entity_id          =       $Timeline->id;
            $Notice->noticeable_id      =       $Timeline->id;
            $Notice->noticeable_type    =       Timeline::class;
            $Notice->save();
        }

        return $Timeline->with(['author', 'author_like', 'comments'])->findOrFail($request->id);
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
        $TimelineComment->user_id       =   Auth::user()->user()->id;
        $TimelineComment->content       =   $request->content;
        $TimelineComment->save();
        $Timeline->increment('comment_num');

        // notice
        $Notice = new Notice;
        $Notice->user_id            =       $Timeline->user_id;
        $Notice->initiator_user_id  =       Auth::user()->user()->id;
        $Notice->type_id            =       11;     // timeline_comment
        $Notice->entity_id          =       $Timeline->id;
        $Notice->noticeable_id      =       $Timeline->id;
        $Notice->noticeable_type    =       Timeline::class;
        $Notice->save();

        return $Timeline->with(['author', 'author_like', 'comments'])->findOrFail($request->id);
    }
}
