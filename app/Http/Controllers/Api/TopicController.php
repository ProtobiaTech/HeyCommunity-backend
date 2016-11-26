<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Topic;
use App\TopicNode;
use App\TopicThumb;
use App\TopicStar;
use App\TopicComment;

class TopicController extends Controller
{
    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getNodes', 'getIndex', 'getShow']]);
    }

    /**
     *
     */
    public function getNodes()
    {
        $nodes = TopicNode::roots()->with('childNodes')->get();
        return $nodes;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $this->validate($request, [
            'type'      =>  'required|string',
            'node_id'   =>  'required|integer',
        ]);

        $query = Topic::with('author', 'comments')->limit(10);

        // type
        if ($request->type === 'hot') {
            $query->orderBy('comment_num', 'desc');
            $query->orderBy('thumb_up_num', 'desc');
            $query->orderBy('updated_at', 'desc');
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        //
        if ($request->node_id !== '0') {
            $query->where('topic_node_id', $request->node_id);
        }

        //
        if ($request->type === 'refresh') {
            $query->where('id', '>', $request->id);
        } else if ($request->type === 'infinite') {
            $query->where('id', '<', $request->id);
        }

        $topics = $query->get()->toArray();

        return $topics;
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
            'title'         =>      'required|string',
            'content'       =>      'required|string',
            'topic_node_id' =>      'required|integer',
        ]);

        $Topic = new Topic;
        $Topic->title           =   $request->title;
        $Topic->content         =   $request->content;
        $Topic->topic_node_id   =   $request->topic_node_id;
        $Topic->user_id         =   Auth::user()->user()->id;

        if ($Topic->save()) {
            return $Topic;
        } else {
            return response('fail', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow(Request $request)
    {
        $this->validate($request, [
             'id'   =>      'required',
        ]);

        $Topic = Topic::findOrFail($request->id);
        return $Topic;
    }

    /**
     *
     */
    public function postSetThumb(Request $request)
    {
        $this->validate($request, [
             'id'       =>      'required|integer',
             'value'    =>      'required|string',
        ]);

        $where = [
            'user_id'   =>  Auth::user()->user()->id,
            'topic_id'  =>  $request->id
        ];

        //
        $oldValue = 'null';
        $TopicThumb = TopicThumb::where($where)->first();
        if ($TopicThumb) {
            $oldValue = $TopicThumb->value == TopicThumb::VALUE_UP ? 'up' : 'down';
            $TopicThumb->delete();
        }
        $case = $request->value . ':' . $oldValue;

        //
        $newValue = $request->value === 'up' ? TopicThumb::VALUE_UP : TopicThumb::VALUE_DOWN;

        //
        $TopicThumb = new TopicThumb;
        $TopicThumb->user_id = Auth::user()->user()->id;
        $TopicThumb->topic_id = $request->id;
        $TopicThumb->value = $newValue;

        if ($TopicThumb->save()) {
            $Topic = Topic::with('author', 'comments')->findOrFail($request->id);

            switch ($case) {
                case 'up:null':
                    $Topic->increment('thumb_up_num');
                    break;
                case 'down:null':
                    $Topic->increment('thumb_down_num');
                    break;
                case 'up:down':
                    $Topic->increment('thumb_up_num');
                    $Topic->decrement('thumb_down_num');
                    break;
                case 'down:up':
                    $Topic->increment('thumb_down_num');
                    $Topic->decrement('thumb_up_num');
                    break;
                default:
                    break;
            }

            return $Topic;
        } else {
            return response('fail', 500);
        }
    }

    /**
     *
     */
    public function postSetStar(Request $request)
    {
        $this->validate($request, [
             'id'   =>      'required',
        ]);

        $where = [
            'user_id'   =>  Auth::user()->user()->id,
            'topic_id'  =>  $request->id
        ];

        $oldTopicStar = TopicStar::where($where)->first();

        $TopicStar = new TopicStar;
        $TopicStar->user_id = Auth::user()->user()->id;
        $TopicStar->topic_Id = $request->id;
        $TopicStar->save();

        $Topic = Topic::with('author', 'comments')->findOrFail($request->id);

        if ($oldTopicStar) {
            $oldTopicStar->delete();
        } else {
            $Topic->increment('star_num');
        }

        return $Topic;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $id)
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

        $Topic = Topic::findOrFail($request->id);

        if ($Topic->user_id === Auth::user()->user()->id || Auth::user()->user()->is_admin) {
            return $Topic->delete() ? ['success'] : response('fail', 500);
        }

        return abort(403, 'Insufficient permissions');
    }

    /**
     *
     */
    public function postStoreComment(Request $request)
    {
        $this->validate($request, [
            'topic_id'              =>      'required|integer',
            'topic_comment_id'      =>      'integer',
            'content'               =>      'required|string',
        ]);

        $Topic = Topic::findOrFail($request->topic_id);
        $TopicComment = new TopicComment;

        if ($request->topic_comment_id) {
            $TopicComment->parent_id   =   $request->topic_comment_id;
        }
        $TopicComment->topic_id     =   $request->topic_id;
        $TopicComment->user_id      =   Auth::user()->user()->id;
        $TopicComment->content      =   $request->content;
        $TopicComment->save();
        $Topic->increment('comment_num');

        /** @todo send notice
        if ($TopicComment->parent_id > 0) {
            if ($TopicComment->parent->user_id !== Auth::user()->user()->id) {
                event(new TriggerNoticeEvent($TopicComment, $TopicComment->parent, 'topic_comment_comment'));
            }
        } else {
            if ($Topic->user_id !== Auth::user()->user()->id) {
                event(new TriggerNoticeEvent($TopicComment, $Topic, 'topic_comment'));
            }
        }
        */

        $Topic = Topic::with(['author', 'comments'])->findOrFail($request->topic_id);
        return $Topic;
    }
}
