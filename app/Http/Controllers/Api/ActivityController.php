<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Activity;
use App\ActivityComment;
use App\ActivityAttend;
use App\ActivityLike;
use Auth;
use Storage;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $ret = Activity::with('author')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate();
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
            'title'         =>      'required',
            'content'       =>      'required|min:10',
            'avatar'        =>      'required',
            'start_date'    =>      'required',
            'end_date'      =>      'required',
        ]);

        // print_r($request->file('avatar'));

        $file = $request->file('avatar');
        $uploadPath = '/uploads/activity/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move(public_path() . $uploadPath, $fileName);

        $Activity = new Activity;
        $Activity->user_id      =       Auth::user()->user()->id;
        $Activity->title        =       $request->title;
        $Activity->content      =       $request->content;
        $Activity->avatar       =       $uploadPath . $fileName;
        $Activity->start_date   =       $request->start_date;
        $Activity->end_date     =       $request->end_date;
        $Activity->save();
        return $Activity;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id)
    {
        $Activity = Activity::with(['author', 'comments'])->findOrFail($id);
        $ret['Activity'] = $Activity;
        $ret['comments'] = $Activity->comments;
        $ret['attends'] = $Activity->attends;

        return $ret;
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

    /**
     *
     */
    public function postLike(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Activity = Activity::findOrFail($request->id);
        $ActivityLike = ActivityLike::where(['user_id' => Auth::user()->user()->id, 'activity_id' => $request->id])->first();
        if ($ActivityLike) {
            $ActivityLike->delete();
            $Activity->decrement('like_num');
        } else {
            $ActivityLike = new ActivityLike;
            $ActivityLike->user_id = Auth::user()->user()->id;
            $ActivityLike->activity_id = $request->id;
            $ActivityLike->save();
            $Activity->increment('like_num');
        }

        return $Activity;
    }

    /**
     *
     */
    public function postAttend(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Activity = Activity::findOrFail($request->id);
        $AcctivityAttend = ActivityAttend::where(['user_id' => Auth::user()->user()->id, 'activity_id' => $request->id])->first();
        if ($AcctivityAttend) {
            $AcctivityAttend->delete();
            $Activity->decrement('attend_num');
        } else {
            $AcctivityAttend = new ActivityAttend;
            $AcctivityAttend->user_id       =   Auth::user()->user()->id;
            $AcctivityAttend->activity_id   =   $request->id;
            $AcctivityAttend->save();
            $Activity->increment('attend_num');
        }

        return $Activity;
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

        $Activity = Activity::findOrFail($request->id);
        $ActivityComment = new ActivityComment;

        $ActivityComment->activity_id   =   $request->id;
        $ActivityComment->user_id       =   Auth::user()->user()->id;
        $ActivityComment->content       =   $request->content;
        $ActivityComment->save();
        $Activity->increment('comment_num');

        return $Activity;
    }

    /**
     *
     */
    public function getComments($id)
    {
        $ActivityComments = ActivityComment::with('author')->where(['activity_id' => $id])->orderBy('created_at', 'desc')->get();
        return $ActivityComments;
    }
}
