<?php

namespace App\Http\Controllers;

use App\Events\ExtractKeywordsEvent;
use App\TopicComment;
use Illuminate\Http\Request;

use App\Topic;
use App\TopicNode;
use App\Keyword;

class TopicController extends Controller
{

    /**
     * TopicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postStore', 'getCreate', 'postStoreComment']]);
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
        $topic = Topic::findOrFail($id);
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
}
