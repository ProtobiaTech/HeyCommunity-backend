<?php

namespace App\Http\Controllers;

use App\Timeline;
use App\Topic;
use App\User;

class UserController extends Controller
{
    /**
     * Profile page
     */
    public function getProfile($id)
    {
        return redirect()->to('/user/timeline/' . $id);
    }

    /**
     * Profile timeline
     */
    public function getTimeline($id)
    {
        $user = User::findOrFail($id);
        $timelines = Timeline::latest()->with('author', 'comments')->where('user_id', $id)->paginate();

        return view('user.timeline', compact('user', 'timelines'));
    }

    /**
     * Profile topic
     */
    public function getTopic($id)
    {
        $user = User::findOrFail($id);
        $topics = Topic::latest()->with('author')->where('user_id', $id)->paginate();

        return view('user.topic', compact('user', 'topics'));
    }
}
