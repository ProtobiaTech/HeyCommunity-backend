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

        $model = new Activity();
        $model->title   =   $request->title;
        $model->content =   $request->content;
        $model->user_id     =   2;

        if ($model->save()) {
            // save avatar
            $file = $request->file('avatar');
            $fileName = 'activity-' . $model->id . '.' . $file->getClientOriginalExtension();
            $fileDir = 'uploads/activity/';
            $file->move($fileDir, $fileName);
            $model->avatar  =   '/' . $fileDir . $fileName;
            $model->save();

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
