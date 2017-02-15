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
use App\Events\TriggerNoticeEvent;

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
            'action'    =>  'string',
            'node_id'   =>  'required|integer',
        ]);

        $query = Topic::with('author', 'comments')->limit(10);

        // node
        if ($request->node_id !== '0') {
            $query->where('topic_node_id', $request->node_id);
        }

        // action
        if ($request->has('action')) {
            $query = $this->setIndexWithMerge($query, $request);
        } else {
            $query = $this->setIndexWithNewList($query, $request);
        }

        $topics = $query->get()->each(function($item, $Key) {
            if (Auth::user()->guest()) {
                $item->is_star = false;
            } else {
                $item->is_star = TopicStar::where(['topic_id' => $item->id, 'user_id' => Auth::user()->user()->id])->count() ? true : false;
            }
        })->toArray();
        return $topics;
    }

    protected function setIndexWithNewList($query, $request)
    {
        if ($request->type === 'hot') {
            $query->orderBy('comment_num', 'desc');
            $query->orderBy('thumb_up_num', 'desc');
            $query->orderBy('updated_at', 'desc');
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        return $query;
    }

    protected function setIndexWithMerge($query, $request)
    {
        if ($request->type === 'hot') {
            $topics = Topic::select('id')
                ->orderBy('comment_num', 'desc')
                ->orderBy('thumb_up_num', 'desc')
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $topics = Topic::select('id')
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        $topics = array_pluck($topics->toArray(), 'id');

        //
        $topicIdList = [];
        $strTopics = implode(',', $topics);

        if ($request->action === 'refresh') {
            $strTopics = strstr($strTopics, $request->id, true);
        } else {
            $strTopics = strstr($strTopics, $request->id);
            $strTopics = ltrim($strTopics, $request->id);
        }

        $strTopics = trim($strTopics, ',');
        $topicIdList = explode(',', $strTopics);

        $query->whereIn('id', $topicIdList);
        return $query;
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

        $Topic = Topic::with('author', 'comments')->findOrFail($request->id);
        $Topic->increment('view_num');
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
            'id'       =>      'required',
            'value'    =>      'required',
        ]);

        $where = [
            'user_id'   =>  Auth::user()->user()->id,
            'topic_id'  =>  $request->id
        ];
        $topicStarExist = TopicStar::where($where)->exists();
        TopicStar::where($where)->delete();

        $Topic = Topic::with('author', 'comments')->findOrFail($request->id);

        if ($request->value) {
            $TopicStar = new TopicStar;
            $TopicStar->user_id = Auth::user()->user()->id;
            $TopicStar->topic_Id = $request->id;
            $TopicStar->save();

            if (!$topicStarExist) {
                $Topic->increment('star_num');
                $Topic->save();
            }

            $Topic->is_star = true;
        } else {
            if ($topicStarExist) {
                $Topic->decrement('star_num');
                $Topic->save();
            }

            $Topic->is_star = false;
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

        if ($TopicComment->parent_id > 0) {
            if ($TopicComment->parent->user_id !== Auth::user()->user()->id) {
                event(new TriggerNoticeEvent($TopicComment, $TopicComment->parent, 'topic_comment_comment'));
            }
        } else {
            if ($Topic->user_id !== Auth::user()->user()->id) {
                event(new TriggerNoticeEvent($TopicComment, $Topic, 'topic_comment'));
            }
        }

        $Topic = Topic::with(['author', 'comments'])->findOrFail($request->topic_id);
        return $Topic;
    }
}
