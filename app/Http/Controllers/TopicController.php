<?php

namespace App\Http\Controllers;

use App\Events\ExtractKeywordsEvent;
use Illuminate\Http\Request;

use Auth;

use App\Topic;
use App\TopicNode;
use App\Keyword;
use App\TopicStar;
use App\TopicThumb;
use App\TopicComment;

class TopicController extends Controller
{

    /**
     * TopicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getIndex', 'getShow']]);
    }

    /**
     * Display a listing of the resource.
     * @param Topic $topic
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Topic $topic)
    {
        $topics     = $topic->getTopicsWithFilter(request('filter', 'index'));
        $topicNodes = TopicNode::rootNodes()->get();
        $keywords   = Keyword::ofType('topic_count');

        if (request()->has('keyword')) {
            $keyword = Keyword::where('name', request()->input('keyword'))->first();
            $topics = $keyword->topics()->paginate();
        }

        if (request()->has('node')) {
            $topicNode = TopicNode::where('name', request()->input('node'))->first();
            $topics = $topicNode->topics()->paginate();
        }

        return view('topic.index', compact('topics', 'topicNodes', 'keywords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $nodes = TopicNode::all()->pluck('name', 'id');

        return view('topic/create', compact('nodes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function postStore(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|string',
            'content'       => 'required|string',
            'topic_node_id' => 'required|integer',
        ]);

        $topic = new Topic;
        $topic->title = $request->title;
        $topic->content = $request->content;
        $topic->topic_node_id = $request->topic_node_id;
        $topic->user_id = auth()->id();
        $topic->save();

        if ($topic->save()) {
            event(new ExtractKeywordsEvent($topic));
            return redirect()->to('/topic');
        } else {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id)
    {
        $topic = Topic::with('node')->findOrFail($id);
        $comments = $topic->comments()->paginate();

        return view('topic.show', compact('topic', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postStoreComment(Request $request)
    {
        $this->validate($request, [
            'topic_id' => 'required|integer',
            'content'  => 'required|string',
        ]);

        $topic = Topic::findOrFail($request->topic_id);
        $topicComment = new TopicComment();

        if ($request->topic_comment_id) {
            $topicComment->parent_id = $request->topic_comment_id;
        }

        $topicComment->user_id = auth()->id();
        $topicComment->topic_id = $request->topic_id;
        $topicComment->content = $request->content;

        if ($topicComment->save()) {
            $topic->increment('comment_num');
            return back();
        } else {
            return back();
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postSetStar(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric',
        ]);

        $topicStar = TopicStar::where(['topic_id' => $request->id, 'user_id' => Auth::user()->user()->id])->first();
        $topic = Topic::findOrFail($request->id);

        if ($topicStar) {
            $topicStar->delete();
            $topic->decrement('star_num');
        } else {
            $topicStar = new TopicStar;
            $topicStar->user_id = Auth::user()->user()->id;
            $topicStar->topic_id = $request->id;
            $topicStar->save();
            $topic->increment('star_num');

        }

        return back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
        $topicThumb = TopicThumb::where($where)->first();
        if ($topicThumb) {
            $oldValue = $topicThumb->value == TopicThumb::VALUE_UP ? 'up' : 'down';
            $topicThumb->delete();
        }
        $case = $request->value . ':' . $oldValue;

        //
        $newValue = $request->value === 'up' ? TopicThumb::VALUE_UP : TopicThumb::VALUE_DOWN;

        //
        $topicThumb = new TopicThumb;
        $topicThumb->user_id = Auth::user()->user()->id;
        $topicThumb->topic_id = $request->id;
        $topicThumb->value = $newValue;

        if ($topicThumb->save()) {
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

            return back();
        } else {
            return response('fail', 500);
        }
    }
}
