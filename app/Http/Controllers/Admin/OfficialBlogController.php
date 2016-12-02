<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Notification;
use Auth;
use App\OfficialBlog;

class OfficialBlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assign['blogs'] = OfficialBlog::orderBy('created_at', 'desc')->paginate();
        return view('admin.official-blog.index', $assign);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.official-blog.create');
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
            'title'                     =>  'required|string|min:4',
            'md_content'                =>  'required|string',
            'editormd-html-code'        =>  'required|string',
        ]);

        $OfficialBlog = new OfficialBlog();
        $OfficialBlog->admin_id = Auth::admin()->user()->id;
        $OfficialBlog->title = $request->title;
        $OfficialBlog->content = $request->get('editormd-html-code');
        $OfficialBlog->md_content = $request->md_content;

        if ($OfficialBlog->save()) {
            Notification::success(trans('dashboard.Successful Operation'));
            return redirect()->route('admin.blog.index');
        } else {
            Notification::error(trans('dashboard.Operation Failure'));
            $request->flash();
            return back();
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
        $assign['blog'] = OfficialBlog::findOrFail($id);
        return view('admin.official-blog.edit', $assign);
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
            'title'                     =>  'required|string|min:4',
            'md_content'                =>  'required|string',
            'editormd-html-code'        =>  'required|string',
        ]);

        $OfficialBlog = OfficialBlog::findOrFail($id);
        $OfficialBlog->title = $request->title;
        $OfficialBlog->content = $request->get('editormd-html-code');
        $OfficialBlog->md_content = $request->md_content;

        if ($OfficialBlog->save()) {
            Notification::success(trans('dashboard.Successful Operation'));
            return redirect()->route('admin.blog.index');
        } else {
            Notification::error(trans('dashboard.Operation Failure'));
            $request->flash();
            return back();
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
        $OfficialBlog = OfficialBlog::findOrFail($id);
        if ($OfficialBlog->delete()) {
            Notification::success(trans('dashboard.Successful Operation'));
        } else {
            Notification::error(trans('dashboard.Operation Failure'));
        }

        return redirect()->route('admin.blog.index');
    }
}
