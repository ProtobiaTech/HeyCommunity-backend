<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Timeline;
use Response, Auth;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assign['timeline'] = Timeline::orderBy('id', 'desc')->paginate();
        return view('admin.timeline.index', $assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.timeline.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     =>      '',
            'content'   =>      'required',
            'attachment'=>      '',
        ]);

        $model = new Timeline();
        $model->title   =   $request->title;
        $model->content =   $request->content;
        $model->user_id     =   Auth::tenant()->user()->id;

        if ($model->save()) {
            // save attachment
            if ($request->attachment) {
                $file = $request->file('attachment');
                $fileName = 'timeline-' . $model->id . '.' . $file->getClientOriginalExtension();
                $fileDir = 'uploads/timeline/';
                $file->move($fileDir, $fileName);
                $model->attachment  =   '/' . $fileDir . $fileName;
                $model->save();
            }

            return redirect()->route('admin.timeline.index');
        } else {
            return redirect()->back();
        }
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
