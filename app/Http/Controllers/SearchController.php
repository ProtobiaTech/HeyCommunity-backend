<?php

namespace App\Http\Controllers;

use App\Timeline;
use App\Topic;
use App\User;

class SearchController extends Controller
{

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $query = request()->input('query', '');
        $users = User::search($query)->get();
        $timelines = Timeline::search($query)->paginate()->setPageName('timeline_page');
        $topics = Topic::search($query)->paginate()->setPageName('topic_page');

        return view('search.index', compact('users', 'timelines', 'topics', 'query'));
    }
}
