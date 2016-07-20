<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use App\TopicComment;
use App\Notice;

use Auth;

class TopicController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth.user', ['only' => ['postStore', 'postCommentPublish', 'postDestroy']]);
        $this->middleware('auth.userAdmin', ['only' => ['postToggleTop', 'postToggleExcellent']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $builder =  Topic::with(['author', 'comments'])->orderBy('id', 'desc')->limit(10);
        if ($request->type === 'refresh') {
            $builder->where('id', '>', $request->id);
        } else if ($request->type === 'infinite') {
            $builder->where('id', '<', $request->id);
        }

        return $builder->get();
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
            // 'avatar'        =>      'required',
        ]);

        /*
        $file = $request->file('avatar');
        $uploadPath = '/uploads/topic/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move(public_path() . $uploadPath, $fileName);
        */

        $Topic = new Topic;
        $Topic->user_id     =       Auth::user()->user()->id;
        $Topic->title       =       $request->title;
        $Topic->content     =       $request->content;
        // $Topic->avatar      =       $uploadPath . $fileName;
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

        if (Auth::user()->check() && Auth::user()->user()->is_admin) {
            return Topic::destroy($request->id);
        } else {
            $Topic = Topic::findOrFail($request->id);
            if ($Topic->user_id === Auth::user()->user()->id) {
                return Topic::destroy($request->id);
            } else {
                return response('Insufficient permissions', 403);
            }
        }
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
        $Topic->increment('comment_num');

        // notice
        $Notice = new Notice;
        $Notice->user_id            =       $Topic->user_id;
        $Notice->initiator_user_id  =       Auth::user()->user()->id;
        $Notice->type_id            =       21;     // topic_comment
        $Notice->noticeable_id      =       $Topic->id;
        $Notice->noticeable_type    =       Topic::class;
        $Notice->save();


        return $Topic->with(['author', 'comments'])->findOrFail($Topic->id);
    }

    /**
     *
     */
    public function postVoteUp(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Topic = Topic::with(['author', 'comments'])->findOrFail($request->id);
        $Topic->increment('vote_up_num');
        return $Topic;
    }

    /**
     *
     */
    public function postVoteDown(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Topic = Topic::with(['author', 'comments'])->findOrFail($request->id);
        $Topic->increment('vote_down_num');
        return $Topic;
    }

    /**
     *
     */
    public function postToggleTop(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Topic = Topic::with(['author', 'comments'])->findOrFail($request->id);
        if ($Topic->is_top == 1) {
            $Topic->is_top = 0;
        } else if ($Topic->is_top == 0) {
            $Topic->is_top = 1;
        }
        $Topic->save();

        return $Topic;
    }

    /**
     *
     */
    public function postToggleExcellent(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Topic = Topic::with(['author', 'comments'])->findOrFail($request->id);
        if ($Topic->is_excellent == 1) {
            $Topic->is_excellent = 0;
        } else if ($Topic->is_excellent == 0) {
            $Topic->is_excellent = 1;
        }
        $Topic->save();

        return $Topic;
    }
}
