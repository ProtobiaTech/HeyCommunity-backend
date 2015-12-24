<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Activity;
use App\User;
use Response, Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assign['activities'] = Activity::orderBy('id', 'desc')->paginate();
        return view('admin.activity.index', $assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.activity.create');
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
            'title'     =>      'required',
            'content'   =>      'required',
            'avatar'    =>      'required',
        ]);

        $Activity = new Activity();
        $Activity->title   =   $request->title;
        $Activity->content =   $request->content;
        $Activity->user_id     =   2;

        if ($Activity->save()) {
            // save avatar
            $file = $request->file('avatar');
            $fileName = 'activity-' . $Activity->id . '.' . $file->getClientOriginalExtension();
            $fileDir = 'uploads/activity/';
            $file->move($fileDir, $fileName);
            $Activity->avatar  =   '/' . $fileDir . $fileName;
            $Activity->save();

            return redirect()->route('admin.activity.index');
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
        $assign['activity'] = Activity::findOrFail($id);
        return view('admin.activity.edit', $assign);
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
        $this->validate($request, [
            'title'     =>      'required',
            'content'   =>      'required',
        ]);

        $Activity = Activity::findOrFail($id);
        $Activity->title   =   $request->title;
        $Activity->content =   $request->content;

        if ($Activity->save()) {
            // save avatar
            if ($request->avatar) {
                $file = $request->file('avatar');
                $fileName = 'activity-' . $Activity->id . '.' . $file->getClientOriginalExtension();
                $fileDir = 'uploads/activity/';
                $file->move($fileDir, $fileName);
                $Activity->avatar  =   '/' . $fileDir . $fileName;
            }
            $Activity->save();

            return redirect()->route('admin.activity.index');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Activity = Activity::findOrFail($id);
        if ($Activity->delete()){
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
