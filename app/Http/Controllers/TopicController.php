<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Topic;
use Carbon\Carbon;

use Auth;
class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $assign['topics'] = Topic::paginate();
        return view('topic.index', $assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $content = "";
        $page_image ="";
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

        if(empty($request->input('title')) || empty($request->input('content'))){
            return redirect()->back();
        }

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
        $topic = Topic::find($id);
        $topic_id = $topic->id;
        $title = $topic->title;
        $content = $topic->content;
        return view('topic.show',compact('title','content','topic_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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

        if(empty($request->input('title')) || empty($request->input('content'))){
            return redirect()->back();
        }

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
