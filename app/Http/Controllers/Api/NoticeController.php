<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Notice;
use App\TimelineImg;
use Auth;

class NoticeController extends Controller
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return Notice::with(['initiator', 'type', 'entity', 'target'])->where('user_id', Auth::user()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->each(function($item, $key) {
                if ($item->target->images) {
                    $item->images = $item->target->images;
                }
            })
            ->toArray();
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
     *
     */
    public function postCheck(Request $request)
    {
        $this->validate($request, [
            'ids'        =>      'required',
        ]);

        foreach ($request->ids as $id) {
            $Notice = Notice::findOrFail($id);
            $Notice->is_checked = true;
            $Notice->save();
        }
        return $this->getIndex();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDestroy(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        Notice::destroy($request->id);
        return $this->getIndex();
    }
}
