<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use App\TopicNode;

class TopicController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $assign['topics'] = Topic::orderBy('id', 'desc')->paginate();
        return view('dashboard.topic.index', $assign);
    }

    /**
     *
     */
    public function getNodes()
    {
        $assign['nodes'] = TopicNode::get();
        return view('dashboard.topic.nodes', $assign);
    }
}
