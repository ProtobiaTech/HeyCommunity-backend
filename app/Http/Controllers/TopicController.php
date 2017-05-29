<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use App\TopicNode;

class TopicController extends Controller
{

    /**
     * TopicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postStore']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $topics = Topic::paginate();
        $topicNodes = TopicNode::rootNodes()->get();
        return view('topic.index', compact('topics', 'topicNodes'));
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

      $topic = new Topic;
      $topic->title           =   $request->title;
      $topic->content         =   $request->content;
      $topic->topic_node_id   =   $request->topic_node_id;
      $topic->user_id         =   auth()->id();
      $topic->save();

      if ($topic->save()) {
        return redirect()->to('/topic');
      } else {
        return back();
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id)
    {
        $topic = Topic::findOrFail($id);

        return view('topic.show', compact('topic'));
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
}
