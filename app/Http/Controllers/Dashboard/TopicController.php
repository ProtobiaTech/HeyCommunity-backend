<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Notification;
use App\Topic;
use App\TopicNode;

class TopicController extends Controller
{
    /**
     *
     */
    public function getIndex()
    {
        $assign['topics'] = Topic::orderBy('id', 'desc')->paginate();
        return view('dashboard.topic.index', $assign);
    }

    /**
     *
     */
    public function getNodes()
    {
        $assign['rootNodes'] = TopicNode::roots()->get();
        return view('dashboard.topic.nodes', $assign);
    }

    /**
     *
     */
    public function getNodeMoveLeft(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
        ]);

        $Node = TopicNode::findOrFail($request->id);
        $r = $Node->moveLeft();

        Notification::success(trans('dashboard.Successful Operation'));
        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function getNodeMoveRight(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
        ]);

        $Node = TopicNode::findOrFail($request->id);
        $r = $Node->moveRight();

        Notification::success(trans('dashboard.Successful Operation'));
        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function postNodeDestroy(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
        ]);

        $Node = TopicNode::findOrFail($request->id);
        Topic::destroy($Node->topics->lists('id')->toArray());
        $Node->delete();

        Notification::success(trans('dashboard.Successful Operation'));
        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function postNodeAdd(Request $request)
    {
        $this->validate($request, [
            'parent_id'     =>      'required|integer',
            'name'          =>      'required|string',
        ]);

        $ParentNode = TopicNode::find($request->parent_id);
        $TopicNode = TopicNode::create(['name' => $request->name]);

        if ($ParentNode) {
            $TopicNode->makeChildOf($ParentNode);
        } else {
            $TopicNode->makeRoot();
        }

        Notification::success(trans('dashboard.Successful Operation'));
        return redirect()->to('dashboard/topic/nodes?edit=true');
    }

    /**
     *
     */
    public function postNodeRename(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required|integer',
            'name'      =>      'required|string',
        ]);

        TopicNode::findOrFail($request->id)->update(['name' => $request->name]);

        Notification::success(trans('dashboard.Successful Operation'));
        return redirect()->to('dashboard/topic/nodes?edit=true');
    }
}
