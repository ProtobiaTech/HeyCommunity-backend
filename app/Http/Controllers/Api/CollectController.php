<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\Collect;

class CollectController extends Controller
{
    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['getMyCollect']]);
    }

    /**
     *
     */
    public function getIndexByUid(Request $request)
    {
        $this->validate($request, [
            'uid'       =>      'required',
        ]);

        $collects = Collect::where(['user_id' => $request->uid])->orderBy('created_at', 'desc')->get();
        return ss($collects);
    }

    /**
     *
     */
    public function getMyCollect()
    {
        $uid = Auth::user()->user()->id;
        $collects = Collect::where(['user_id' => $uid])->orderBy('created_at', 'desc')->get();
        return ss($collects);
    }

    /**
     *
     */
    public function getMyFollowCollect()
    {
        // @todo my follow collect
        $collects = [];
        return ss($collects);
    }

    /**
     *
     */
    public function getShow(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $collect = Collect::find($request->id);
        return ss($collect);
    }

    /**
     *
     */
    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $collect = Collect::find($request->id);
        return ss($collect);
    }

    /**
     *
     */
    public function postDestroy(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $ret = Collect::destroy($request->id);
        return ss($ret);
    }

    /**
     *
     */
    public function postStore(Request $request)
    {
        $this->validate($request, [
            'name'        =>      'required',
        ]);

        $data = $request->all();

        $collect = Collect::create($data);
        return ss($collect);
    }
}
