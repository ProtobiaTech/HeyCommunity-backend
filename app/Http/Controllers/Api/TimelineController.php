<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeline;
use Auth;

class TimelineController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth.user', ['only' => ['postStore']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $ret = Timeline::with('author')->orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10);
        return $ret;
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
    public function postStore(Request $request)
    {
        $this->validate($request, [
            'content'       =>      'required',
            'attachment'    =>      'required',
        ]);

        $file = $request->file('attachment');
        $uploadPath = '/uploads/timeline/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
        $file->move(public_path() . $uploadPath, $fileName);

        $Timeline = new Timeline;
        $Timeline->user_id      =       Auth::user()->user()->id;
        $Timeline->content      =       $request->content;
        $Timeline->attachment   =       $uploadPath . $fileName;
        $Timeline->save();
        return $Timeline;
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

    /**
     *
     */
    public function postLike(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Timeline = Timeline::findOrFail($request->id);
        $Timeline->increment('like_num');

        return $Timeline;
    }
}
