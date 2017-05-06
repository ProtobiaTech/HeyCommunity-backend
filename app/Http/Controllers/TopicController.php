<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\TopicThumb;
use App\Topic;
use App\TopicComment;
use App\Events\TriggerNoticeEvent;
use Carbon\Carbon;

use Auth;
use PhpParser\Comment;

class TopicController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getIndex','getShow','getThumbUp']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $query = Topic::with('author', 'comments')->limit(50);

        // action
        if ($request->has('action')) {
            $query = $this->setIndexWithMerge($query, $request);
        } else {
            $query = $this->setIndexWithNewList($query, $request);
        }

        $topics = $query->get();

        return view('topic.index', compact('topics'));
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
            $topic = Topic::with('author', 'comments')->findOrFail($request->id);

            switch ($case) {
                case 'up:null':
                    $topic->increment('thumb_up_num');
                    break;
                case 'down:null':
                    $topic->increment('thumb_down_num');
                    break;
                case 'up:down':
                    $topic->increment('thumb_up_num');
                    $topic->decrement('thumb_down_num');
                    break;
                case 'down:up':
                    $topic->increment('thumb_down_num');
                    $topic->decrement('thumb_up_num');
                    break;
                default:
                    break;
            }
            return redirect()->back()->with('topic',[$topic]);
        } else {
            return response('fail', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $content = "";
        $title = "";

        return view('topic.create', compact('content','title'));

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
            'title'     =>      'required|string',
            'content'  =>      'required|string',
        ]);

        $title = $request->input('title');
        $content = $request->input('content');
        $topic = Topic::create(['title' => $title,'content' => $content]);

        $topic_id = Auth::user()->user()->topics()->save($topic)->id;

        return redirect('topic/show/'.$topic_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id)
    {
        $topic = Topic::with('author', 'comments')->findOrFail($id);
        $topic->increment('view_num');

        return view('topic.show',compact('topic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id topic_id
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request,$id)
    {
        $topic = Topic::find($id);

        $topic_id = $topic->id;
        $content = $topic->content;
        $title = $topic->title;

        return view('topic.edit',compact('title','content','topic_id'));
    }

    /**
     * @param Request $request
     * @param $id topic_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postEdit(Request $request,$id)
    {
        $topic = Topic::find($id);

        $topic_id = $topic->id;
        $content = $topic->content;
        $title = $topic->title;

        return view('topic.edit',compact('title','content','topic_id'));
    }

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

        $topic = Topic::with(['author', 'comments'])->findOrFail($request->topic_id);
        return view('topic.show',compact('topic'));
    }

    public function getEditComment(Request $request,$id)
    {
        $comment = TopicComment::find($id);

        return view('topic.edit_comment',compact('comment'));
    }

    public function putUpdateComment(Request $request,$id)
    {
        $this->validate($request, [
            'topic_comment_id'      =>      'integer',
            'content'               =>      'required|string',
        ]);
        $comment = TopicComment::find($id);
        $comment->content = $request->input('content');
        $comment->save();

        $topic = $comment->topic()->get()[0];

        return redirect('topic/show/'.$topic->id)
        ->withSuccess('Commit Updated Successful!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function putUpdate(Request $request,$id)
    {

        $this->validate($request, [
            'title'     =>      'required|string',
            'content'  =>      'required|string',
        ]);

        $topic = Topic::findOrFail($id);
        $title = $request->input('title');
        $content = $request->input('content');
        $topic->fill(['title' => $title , 'content' => $content]);
        $topic->save();
        return redirect('topic/show/'.$id)
            ->withSuccess('Topic saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDestroy($id)
    {
        //
    }
}
