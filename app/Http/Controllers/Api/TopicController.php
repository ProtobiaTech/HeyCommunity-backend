<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use App\TopicNode;

class TopicController extends Controller
{
    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth', ['only' => []]);
    }

    /**
     *
     */
    public function getNodes()
    {
        $nodes = TopicNode::where(['parent_id' => 0])->with('childNodes')->get();
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

        $query = Topic::with('author')->limit(10);

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
