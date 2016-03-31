<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use App\TopicComment;

use Auth;

class TopicController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth.user', ['only' => ['postStore', 'postCommentPublish', 'postDestroy']]);
        $this->middleware('auth.userAdmin', ['only' => ['postDestroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $ret = Topic::with('author')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10);
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
            'content'       =>      'required',
            'avatar'        =>      'required',
        ]);

        $file = $request->file('avatar');
        $uploadPath = '/uploads/topic/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move(public_path() . $uploadPath, $fileName);

        $Topic = new Topic;
        $Topic->user_id     =       Auth::user()->user()->id;
        $Topic->title       =       $request->title;
        $Topic->content     =       $request->content;
        $Topic->avatar      =       $uploadPath . $fileName;
        $Topic->save();
        return $Topic;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id)
    {
        return Topic::with(['author', 'comments'])->findOrFail($id);
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

        return Topic::destroy($request->id);
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

        $Topic = Topic::findOrFail($request->id);
        $TopicComment = new TopicComment;

        $TopicComment->topic_id     =   $request->id;
        $TopicComment->user_id      =   Auth::user()->user()->id;
        $TopicComment->content      =   $request->content;
        $TopicComment->save();
        // $Topic->increment('comment_num');

        return $Topic;
    }

}
